#!/bin/sh
set -eu

php artisan migrate --force

if [ ! -L public/storage ]; then
    php artisan storage:link
fi

php artisan config:cache
php artisan route:cache
php artisan view:cache
