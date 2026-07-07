#!/bin/bash
set -e

# Generate APP_KEY if not already set by Railway
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force --quiet 2>/dev/null || true
fi

# Override .env for Railway production
echo "APP_DEBUG=true" >> /app/.env
echo "SESSION_DRIVER=file" >> /app/.env
echo "CACHE_STORE=file" >> /app/.env

# Clear all caches (avoids stale view/config/route issues)
php artisan route:clear --quiet 2>/dev/null || true
php artisan config:clear --quiet 2>/dev/null || true
php artisan view:clear --quiet 2>/dev/null || true

# Re-publish Filament assets and refresh navigation
php artisan filament:upgrade --quiet --no-interaction 2>/dev/null || true

# Cache routes, config, and events for performance
php artisan optimize --quiet 2>/dev/null || true

# Run migrations
php artisan migrate --force

# Create storage symlink so profile photos are accessible
php artisan storage:link --force --quiet 2>/dev/null || true

# Sync Shield roles & assign super_admin to all admin users
php artisan shield:sync-admin --no-interaction 2>/dev/null || true

echo "Starting Laravel scheduler, PHP-FPM, and Nginx..."

# Start Laravel scheduler (daemon — runs schedule:run every minute)
php artisan schedule:work --quiet --no-interaction 2>/dev/null &

# Start PHP-FPM in background
php-fpm -D

# Start Nginx in foreground
exec nginx
