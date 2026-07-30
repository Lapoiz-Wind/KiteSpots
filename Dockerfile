# syntax=docker/dockerfile:1

FROM php:8.3-apache AS app

# --- System dependencies & PHP extensions ---------------------------------
RUN apt-get update && apt-get install -y --no-install-recommends \
        libicu-dev \
        libpq-dev \
        libzip-dev \
        libpng-dev \
        libonig-dev \
        unzip \
        git \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j"$(nproc)" \
        intl \
        pdo \
        pdo_pgsql \
        zip \
        gd \
        opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Apache configuration: Symfony's public/ dir is the document root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
    && a2enmod rewrite

# Recommended PHP/OPcache settings for production
RUN { \
        echo 'opcache.memory_consumption=128'; \
        echo 'opcache.interned_strings_buffer=8'; \
        echo 'opcache.max_accelerated_files=10000'; \
        echo 'opcache.validate_timestamps=0'; \
        echo 'opcache.enable_cli=1'; \
    } > /usr/local/etc/php/conf.d/opcache-recommended.ini \
    && { \
        echo 'memory_limit=256M'; \
        echo 'upload_max_filesize=20M'; \
        echo 'post_max_size=20M'; \
    } > /usr/local/etc/php/conf.d/symfony.ini

# --- Composer ---------------------------------------------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Install dependencies first for better layer caching
COPY composer.json composer.lock symfony.lock ./
RUN composer install --no-dev --no-interaction --no-scripts --no-progress --optimize-autoloader

# Copy the rest of the application
COPY . .

ENV APP_ENV=prod \
    APP_DEBUG=0

RUN composer dump-autoload --no-dev --optimize \
    && php bin/console assets:install public --env=prod \
    && chown -R www-data:www-data var

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80

ENTRYPOINT ["entrypoint.sh"]
CMD ["apache2-foreground"]
