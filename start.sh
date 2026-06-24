#!/bin/bash
set -e

# Generate APP_KEY if not already set by Railway
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force --quiet 2>/dev/null || true
fi

# Clear all caches (avoids stale view/config/route issues)
php artisan route:clear --quiet 2>/dev/null || true
php artisan config:clear --quiet 2>/dev/null || true
php artisan view:clear --quiet 2>/dev/null || true

# Run migrations
php artisan migrate --force

# Generate Shield permissions & assign super_admin (only on first deploy)
if ! php artisan tinker --execute="echo \DB::table('roles')->count();" --no-interaction 2>/dev/null | grep -q '[1-9]'; then
    php artisan shield:generate --all --panel=admin --no-interaction 2>/dev/null || true
    php artisan tinker --execute="\$u = \App\Models\User::where('role','admin')->first(); if(\$u) { \$u->assignRole('super_admin'); echo 'Assigned super_admin to '.\$u->email; }" --no-interaction 2>/dev/null || true
fi

echo "Starting Nginx + PHP-FPM on port 8080..."

# Start PHP-FPM in background
php-fpm -D

# Start Nginx in foreground
exec nginx
