#!/bin/sh
set -eu

# Set default PORT if not provided (Railway sets this automatically)
export PORT="${PORT:-8080}"

# Substitute environment variables in nginx config (like $PORT)
envsubst '${PORT}' < /etc/nginx/nginx.conf > /tmp/nginx.conf.tmp
mv /tmp/nginx.conf.tmp /etc/nginx/nginx.conf

# Create storage directory structure if it doesn't exist
mkdir -p /var/www/html/storage/framework/cache/data
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/bootstrap/cache

# Set proper permissions for storage and bootstrap cache
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache

# Create storage symlink if it doesn't exist
if [ ! -L /var/www/html/public/storage ]; then
    php /var/www/html/artisan storage:link --force
fi

# Run Laravel artisan commands for optimization (skip if APP_ENV is local)
if [ "${APP_ENV:-production}" != "local" ]; then
    php /var/www/html/artisan config:cache
    php /var/www/html/artisan route:cache
    php /var/www/html/artisan view:cache
fi

# Run migrations if APP_RUN_MIGRATIONS is set to true
if [ "${APP_RUN_MIGRATIONS:-false}" = "true" ]; then
    php /var/www/html/artisan migrate --force
fi

# Start PHP-FPM and Nginx
php-fpm -R &
nginx -g "daemon off;"
