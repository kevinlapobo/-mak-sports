#!/bin/bash
set -e

# Generate APP_KEY only if not already set
if ! php artisan key:generate --show --quiet 2>/dev/null | grep -q .; then
    php artisan key:generate --force --quiet 2>/dev/null || true
fi

# Clear all caches (avoids stale view/config/route issues)
php artisan route:clear --quiet 2>/dev/null || true
php artisan config:clear --quiet 2>/dev/null || true
php artisan view:clear --quiet 2>/dev/null || true

# Run migrations
php artisan migrate --force

echo "Starting Nginx + PHP-FPM on port 8080..."

# Start PHP-FPM in background
php-fpm -D

# Start Nginx in foreground
exec nginx
