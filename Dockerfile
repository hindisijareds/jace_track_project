FROM php:8.1-apache

# Install system dependencies + ALL PHP extensions
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev libzip-dev unzip \
    && docker-php-ext-install pdo pdo_mysql mbstring xml zip exif bcmath gd

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install Composer v2
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Install dependencies with VERBOSE output to see errors
RUN composer install --optimize-autoloader --no-dev --no-scripts 2>&1

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html/storage \
    && chmod -R 755 /var/www/html/storage

# Expose port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
