FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git unzip curl nginx supervisor libpq-dev libonig-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . /var/www/html

RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

COPY ./.deploy/nginx.conf /opt/templates/nginx.conf
COPY ./.deploy/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY ./.deploy/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

RUN rm -f /etc/nginx/sites-enabled/default /etc/nginx/conf.d/default.conf true
RUN ln -sf /dev/stdout /var/log/nginx/access.log \
 && ln -sf /dev/stderr /var/log/nginx/error.log

EXPOSE 8080
CMD ["/usr/local/bin/start.sh"]
