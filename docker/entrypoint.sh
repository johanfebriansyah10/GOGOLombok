#!/bin/sh
set -eu

# Set default PORT jika tidak disediakan oleh Railway
export PORT="${PORT:-8080}"

# Substitusi environment variables di konfigurasi Nginx (seperti $PORT)
envsubst '${PORT}' < /etc/nginx/nginx.conf > /tmp/nginx.conf.tmp
mv /tmp/nginx.conf.tmp /etc/nginx/nginx.conf

# Tetap buat struktur direktori jika belum ada (Failsafe)
mkdir -p /var/www/html/storage/framework/cache/data \
         /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/logs \
         /var/www/html/bootstrap/cache

# Membuat symlink storage jika belum ada
if [ ! -L /var/www/html/public/storage ]; then
    echo "Creating storage symlink..."
    php /var/www/html/artisan storage:link --force
fi

# Jalankan optimasi Laravel untuk environment Production
if [ "${APP_ENV:-production}" != "local" ]; then
    echo "Caching Laravel configurations for production..."
    php /var/www/html/artisan config:cache
    php /var/www/html/artisan route:cache
    php /var/www/html/artisan view:cache
fi

# Jalankan migrasi otomatis jika variabel APP_RUN_MIGRATIONS bernilai true
if [ "${APP_RUN_MIGRATIONS:-false}" = "true" ]; then
    echo "Running database migrations..."
    php /var/www/html/artisan migrate --force
fi

# -----------------------------------------------------------------------------
# Menjalankan Service
# -----------------------------------------------------------------------------
echo "Starting PHP-FPM..."
# Jalankan PHP-FPM di background tanpa flag -R untuk kestabilan user pool
php-fpm &

echo "Starting Nginx on port $PORT..."
# Jalankan Nginx di foreground agar container tetap hidup
exec nginx -g "daemon off;"
