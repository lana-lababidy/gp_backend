#!/usr/bin/env bash
set -e

cd /var/www/html

# مسح الكاشات القديمة
php artisan config:clear
php artisan route:clear
php artisan view:clear

# إنشاء روابط التخزين
if [ ! -L "public/storage" ]; then
    php artisan storage:link || true
fi

# تشغيل supervisor لإدارة php-fpm و nginx
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
