FROM php:8.2-fpm

# Installer les extensions et Supervisor
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Installer Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Copier le code source
WORKDIR /var/www/html
COPY . .

# Installer les dépendances
RUN composer install --no-dev --optimize-autoloader

# Donner les permissions nécessaires
RUN chmod -R 755 .
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN sed -i "s|listen = /run/php/php8.2-fpm.sock|listen = 9000|" /usr/local/etc/php-fpm.d/www.conf

CMD php artisan generate:crypto-prices & php-fpm
