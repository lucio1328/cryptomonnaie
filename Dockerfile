FROM php:8.2-fpm

# Installer les extensions nécessaires
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Installer Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Installer les dépendances Laravel
WORKDIR /var/www/html
COPY . .
RUN composer install

# Donner les permissions nécessaires
RUN chmod -R 775 storage bootstrap/cache

# Lancer Laravel
CMD php artisan serve --host=0.0.0.0 --port=80
