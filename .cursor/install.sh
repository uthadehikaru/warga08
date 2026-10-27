#!/usr/bin/env bash
# Idempotent environment bootstrap for the warga08 Laravel application.
# Safe to run repeatedly: it installs system dependencies only when missing,
# refreshes PHP/Node dependencies, and prepares a ready-to-use SQLite database.
set -euo pipefail

cd "$(dirname "$0")/.."

PHP_VERSION="8.3"

# 1. System dependencies (PHP + extensions and Composer) on the default image.
if ! command -v php >/dev/null 2>&1; then
  echo "==> Installing PHP ${PHP_VERSION} and required extensions"
  sudo apt-get update -y
  sudo DEBIAN_FRONTEND=noninteractive apt-get install -y --no-install-recommends \
    "php${PHP_VERSION}-cli" \
    "php${PHP_VERSION}-common" \
    "php${PHP_VERSION}-bcmath" \
    "php${PHP_VERSION}-curl" \
    "php${PHP_VERSION}-mbstring" \
    "php${PHP_VERSION}-xml" \
    "php${PHP_VERSION}-zip" \
    "php${PHP_VERSION}-gd" \
    "php${PHP_VERSION}-intl" \
    "php${PHP_VERSION}-sqlite3" \
    "php${PHP_VERSION}-mysql" \
    unzip git curl ca-certificates
fi

if ! command -v composer >/dev/null 2>&1; then
  echo "==> Installing Composer"
  curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
  sudo php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer
  rm -f /tmp/composer-setup.php
fi

# 2. PHP dependencies.
echo "==> composer install"
composer install --no-interaction --prefer-dist --no-progress

# 3. Node dependencies and front-end assets.
echo "==> npm ci"
npm ci
echo "==> npm run build"
npm run build

# 4. Environment file + application key.
if [ ! -f .env ]; then
  echo "==> Creating .env from .env.example (SQLite dev database)"
  cp .env.example .env
  sed -i 's/^DB_CONNECTION=mysql/DB_CONNECTION=sqlite/' .env
  sed -i 's|^DB_HOST=.*|# DB_HOST=127.0.0.1|' .env
  sed -i 's|^DB_PORT=.*|# DB_PORT=3306|' .env
  sed -i 's|^DB_DATABASE=.*|# DB_DATABASE=laravel|' .env
  sed -i 's|^DB_USERNAME=.*|# DB_USERNAME=root|' .env
  sed -i 's|^DB_PASSWORD=.*|# DB_PASSWORD=|' .env
  sed -i 's|^APP_URL=.*|APP_URL=http://localhost:8000|' .env
fi

if ! grep -q '^APP_KEY=base64:' .env; then
  echo "==> Generating application key"
  php artisan key:generate --force
fi

# 5. SQLite database + schema + seed data.
mkdir -p database
touch database/database.sqlite
echo "==> Running migrations"
php artisan migrate --force

# Seed only when the database has no users yet. The UserSeeder generates 100
# random "warga" users in the local environment, so re-seeding on every install
# would keep growing the table; guarding on an empty users table keeps the
# install script idempotent.
USER_COUNT="$(php artisan tinker --execute='echo \App\Models\User::query()->count();' 2>/dev/null | tail -n 1 | tr -dc '0-9')"
if [ -z "${USER_COUNT}" ] || [ "${USER_COUNT}" = "0" ]; then
  echo "==> Seeding database"
  php artisan db:seed --force
else
  echo "==> Database already seeded (${USER_COUNT} users); skipping seed"
fi

echo "==> Environment ready."
