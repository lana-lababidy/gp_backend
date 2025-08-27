#!/usr/bin/env bash
set -e

export PORT="${PORT:-8080}"

envsubst '${PORT}' < /opt/templates/nginx.conf > /etc/nginx/conf.d/default.conf

cd /var/www/html

php artisan storage:link true
php artisan config:cache true
php artisan route:cache true

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
