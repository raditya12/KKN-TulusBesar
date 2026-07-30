#!/bin/sh
set -e

# Copy .env if not exists
if [ ! -f .env ]; then
    echo "Creating .env file from .env.example..."
    cp .env.example .env
fi

# Install composer dependencies if vendor directory doesn't exist
if [ ! -d "vendor" ]; then
    echo "Installing Composer dependencies..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Generate application key if not set
if ! grep -q "^APP_KEY=base64:" .env; then
    echo "Generating Application Key..."
    php artisan key:generate --force
fi

# Run storage link if not linked
if [ ! -L "public/storage" ]; then
    echo "Creating storage symlink..."
    php artisan storage:link || true
fi

# Start PHP-FPM
echo "Starting PHP-FPM..."
exec php-fpm
