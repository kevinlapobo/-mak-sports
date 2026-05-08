#!/bin/bash
set -e
php artisan migrate --force
php artisan route:clear
echo "Starting on port 8080..."
exec php -S 0.0.0.0:8080 -t /app/public
