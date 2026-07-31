# KiteSpots

Application Symfony de gestion et cartographie de spots de kitesurf (fiches spots, liens utiles, import/export Excel, carte interactive).

## Sommaire

- [Stack technique](#stack-technique)
- [Architecture d'hébergement](#architecture-dhébergement)
- [CI/CD](#cicd)
- [Déploiement (Render + Neon)](#déploiement-render--neon)
- [Développement local](#développement-local)
- [Variables d'environnement](#variables-denvironnement)
- [Authentification admin](#authentification-admin)
- [Dépannage](#dépannage)

## Stack technique

- **Framework** : Symfony 7.4 (PHP 8.2+)
- **ORM** : Doctrine ORM / Migrations
- **Base de données** : PostgreSQL 16
- **Assets** : Symfony AssetMapper (pas de Node.js/Webpack requis)
- **Serveur web (prod)** : Apache (image `php:8.3-apache`)
- **Tests** : PHPUnit

## Architecture d'hébergement

Le projet est hébergé entièrement sur des offres **gratuites**, séparant l'application (stateless) de la base de données (stateful) :

| Composant         | Fournisseur                         | Rôle                                              |
|-------------------|--------------------------------------|----------------------------------------------------|
| Code source       | [GitHub](https://github.com/Lapoiz-Wind/KiteSpots) | Dépôt Git + déclencheur CI/CD                       |
| CI                 | GitHub Actions                       | Lint, validation schéma, tests PHPUnit              |
| Hébergement web    | [Render](https://render.com) (plan Free) | Build & run du conteneur Docker de l'application    |
| Base de données    | [Neon](https://neon.tech) (plan Free)    | PostgreSQL managé, serverless, persistant           |

> ℹ️ Railway a été écarté car son offre gratuite permanente n'existe plus (crédit d'essai limité puis payant).

### Pourquoi séparer web et base de données ?

Les plans gratuits actuels des PaaS (Render, Koyeb, Fly.io…) n'incluent généralement plus de base de données gratuite persistante intégrée. Neon fournit un PostgreSQL serverless gratuit et durable, indépendant du cycle de vie du service web.

⚠️ **Limite du plan gratuit Render** : le service web se met en veille après ~15 minutes d'inactivité et redémarre (cold start ~30-60s) à la requête suivante. Comportement normal et attendu pour un hébergement gratuit.

## CI/CD

### `.github/workflows/ci.yml`

Déclenché sur chaque push/PR vers `main`/`master`. Étapes :
1. Installation des dépendances Composer (avec cache)
2. `composer validate`
3. `lint:yaml`, `lint:twig`, `lint:container`
4. `doctrine:schema:validate` contre un PostgreSQL de service (conteneur éphémère GitHub Actions)
5. `doctrine:migrations:migrate`
6. `phpunit`

### `.github/workflows/deploy.yml`

Render redéploie **automatiquement** à chaque push sur `main` grâce à son intégration native GitHub (configurée dans [`render.yaml`](./render.yaml)). Ce workflow est optionnel : il ne fait qu'appeler un *deploy hook* Render si le secret GitHub `RENDER_DEPLOY_HOOK_URL` est renseigné (utile pour forcer un redéploiement manuel indépendamment de l'auto-deploy).

## Déploiement (Render + Neon)

### 1. Créer la base de données sur Neon

1. https://neon.tech → créer un compte (ex. via GitHub) → "Create Project"
2. Récupérer la **connection string** fournie par Neon
3. L'adapter au format attendu par Doctrine :
   ```
   postgresql://<user>:<password>@<host>/<dbname>?serverVersion=16&charset=utf8&sslmode=require&channel_binding=require
   ```

### 2. Déployer le service web sur Render

1. https://render.com → connecter le compte GitHub
2. "New" → "Blueprint" → sélectionner le dépôt `Lapoiz-Wind/KiteSpots`
3. Render détecte automatiquement [`render.yaml`](./render.yaml) (service Docker, plan Free)
4. Compléter dans le dashboard Render les variables marquées `sync: false` :
   - `DATABASE_URL` : la connection string Neon (étape 1)
   - `ADMIN_PASSWORD_HASH` : hash bcrypt du mot de passe admin (voir [Authentification admin](#authentification-admin))
5. Render build l'image via le [`Dockerfile`](./Dockerfile) et déploie. Au démarrage, [`docker/entrypoint.sh`](./docker/entrypoint.sh) attend que la base soit joignable puis exécute automatiquement `doctrine:migrations:migrate`.
6. Une URL publique est générée automatiquement (`https://<nom-service>.onrender.com`).

### Fichiers clés du déploiement

| Fichier                                | Rôle |
|-----------------------------------------|------|
| [`Dockerfile`](./Dockerfile)             | Image de production PHP 8.3 + Apache, extensions pdo_pgsql/intl/gd/zip/opcache |
| [`docker/entrypoint.sh`](./docker/entrypoint.sh) | Adapte le port dynamique (`$PORT`), attend la DB, joue les migrations, vide le cache |
| [`public/.htaccess`](./public/.htaccess)  | Réécriture d'URL Apache vers le front-controller Symfony (`index.php`) |
| [`render.yaml`](./render.yaml)           | Blueprint Render (service Docker, plan Free, variables d'env) |
| [`.dockerignore`](./.dockerignore)       | Exclusions du contexte de build Docker |

## Développement local

```powershell
composer install
docker compose up -d          # démarre PostgreSQL local (compose.yaml)
php bin/console doctrine:migrations:migrate
symfony server:start          # ou php -S 127.0.0.1:8000 -t public
```

Lancer les tests :
```powershell
php bin/phpunit
```

## Variables d'environnement

| Variable                | Description                                                                 | Où la définir |
|--------------------------|-------------------------------------------------------------------------------|----------------|
| `APP_ENV`                | Environnement Symfony (`dev`, `prod`, `test`)                                  | `.env` / plateforme |
| `APP_SECRET`             | Secret Symfony (CSRF, sessions…). Générer une valeur aléatoire en prod.        | Render (générée automatiquement) |
| `DATABASE_URL`           | DSN de connexion PostgreSQL                                                    | `.env` (local) / Render (Neon en prod) |
| `ADMIN_PASSWORD_HASH`    | Hash bcrypt du mot de passe du compte `admin`                                  | `.env` (dev) / Render (prod) |
| `TRUSTED_PROXIES`        | Plages IP de confiance pour les en-têtes `X-Forwarded-*` (reverse proxy PaaS)  | `.env` |

## Authentification admin

L'application utilise un unique compte `admin` (provider "in memory", pas de base utilisateurs) protégeant les actions de gestion des spots (`création`, `édition`, `suppression`, `import`, `export`).

Le mot de passe n'est **jamais stocké en clair** : seul son hash bcrypt est configuré via la variable `ADMIN_PASSWORD_HASH`.

Pour générer un nouveau hash (à faire à chaque changement de mot de passe, et impérativement avec une valeur différente entre dev et prod) :
```powershell
php bin/console security:hash-password
```
Copier le hash affiché dans `ADMIN_PASSWORD_HASH` (`.env.local` en dev, variables d'environnement Render en production — jamais commité en clair).

## Dépannage

- **Le site répond "504 Gateway Timeout" à la première requête** : normal si le service Render était en veille (cold start). Réessayer après quelques dizaines de secondes.
- **Erreur de syntaxe SQL dans une migration (`AUTOINCREMENT`, `CLOB`...)** : signe qu'une migration a été générée avec `DATABASE_URL` pointant vers SQLite au lieu de PostgreSQL. Supprimer la migration fautive et la régénérer avec `php bin/console doctrine:migrations:diff` en pointant vers une base PostgreSQL réelle.
- **404 sur toutes les routes sauf `/`** : vérifier que [`public/.htaccess`](./public/.htaccess) est bien présent et que le Dockerfile active `AllowOverride All` pour le document root Apache (nécessaire pour que `mod_rewrite` route les URLs vers `index.php`).
