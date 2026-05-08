#!/bin/bash
set -e
php artisan migrate --force || true
php artisan db:seed --force || true
echo "Starting on port 8080..."
exec php -S 0.0.0.0:8080 -t /app/public
