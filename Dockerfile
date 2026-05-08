FROM php:8.3-fpm

WORKDIR /app

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip pdo pdo_mysql intl \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

# Create .env from example if it doesn't exist
RUN if [ ! -f .env ]; then cp .env.example .env; fi

# Install Composer dependencies
RUN composer install --optimize-autoloader --no-dev --no-interaction

# Generate APP_KEY
RUN php artisan key:generate --force

# Fix storage permissions
RUN chmod -R 777 storage bootstrap/cache

RUN chmod +x start.sh

EXPOSE 8080
CMD ["/bin/bash", "/app/start.sh"]

