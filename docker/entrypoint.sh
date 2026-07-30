#!/bin/sh
set -e

# PaaS platforms (Render, Koyeb, etc.) inject a dynamic $PORT the app must listen on.
PORT="${PORT:-80}"
sed -ri "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -ri "s/:80>/:${PORT}>/g" /etc/apache2/sites-available/000-default.conf

# Wait for the database to be reachable before running migrations.
if [ -n "$DATABASE_URL" ]; then
    echo "Waiting for database to be ready..."
    ATTEMPTS=0
    until php bin/console doctrine:query:sql "SELECT 1" --env=prod >/dev/null 2>&1 || [ $ATTEMPTS -ge 30 ]; do
        ATTEMPTS=$((ATTEMPTS + 1))
        sleep 2
    done

    echo "Running database migrations..."
    php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration --env=prod
fi

echo "Warming up cache..."
php bin/console cache:clear --env=prod --no-debug || true

exec "$@"
