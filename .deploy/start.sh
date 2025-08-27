#!/usr/bin/env bash
set -e

# انتقل إلى مجلد المشروع
cd /var/www/html

# ربط مجلد التخزين بالـ public (إذا لم يكن موجود)
if [ ! -L "public/storage" ]; then
    php artisan storage:link || true
fi

# بناء الكاش الخاص بـ Laravel
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# تشغيل supervisor لإدارة php-fpm و nginx
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
