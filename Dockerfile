FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev libzip-dev unzip \
    && docker-php-ext-install pdo pdo_mysql mbstring xml zip exif bcmath gd

RUN a2enmod rewrite
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
COPY . .

# RUN COMPOSER AND SAVE FULL ERROR TO A FILE
RUN composer install --optimize-autoloader --no-dev --no-scripts > /tmp/composer.log 2>&1 || \
    (echo "=== COMPOSER FAILED ===" && cat /tmp/composer.log && exit 1)

# Show the log file contents
RUN cat /tmp/composer.log

# Continue (will never reach here if composer fails)
RUN chown -R www-data:www-data /var/www/html/storage
EXPOSE 80
CMD ["apache2-foreground"]
