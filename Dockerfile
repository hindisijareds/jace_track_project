FROM php:8.1-apache

# Install ALL required system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo pdo_mysql mbstring xml zip exif bcmath gd

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install Composer v2 (stable)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files FIRST (crucial for caching)
COPY composer.json composer.lock ./

# Install dependencies with NO SCRIPTS (prevents exit code 2)
RUN composer install --optimize-autoloader --no-dev --no-scripts --no-autoloader

# NOW copy the rest of your application
COPY . .

# Generate optimized autoloader AFTER all files are copied
RUN composer dump-autoload --optimize

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Expose port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
