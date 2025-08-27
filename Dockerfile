# Use official PHP image with FPM
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies + gettext (envsubst)
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libonig-dev curl supervisor nginx gettext \
    && docker-php-ext-install pdo_mysql mbstring zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy project files
COPY . .

# Copy start script and make it executable
COPY .deploy/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Set proper permissions for Laravel folders
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Expose port 80 (matches nginx inside start.sh)
EXPOSE 80

# Start container
CMD ["/usr/local/bin/start.sh"]
