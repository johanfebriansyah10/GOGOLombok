# =============================================================================
# Stage 1: Build frontend assets with Node
# =============================================================================
FROM node:20-alpine AS node-build

WORKDIR /app

# Install dependencies first (for better caching)
COPY package.json package-lock.json* ./
RUN npm ci --no-audit --no-fund

# Copy source and build
COPY postcss.config.js tailwind.config.js vite.config.js ./
COPY resources/ resources/
# Pastikan folder public ada agar hasil build tidak salah tempat
COPY public/ public/
RUN npm run build

# =============================================================================
# Stage 2: Install Composer dependencies
# =============================================================================
FROM composer:2 AS composer-build

WORKDIR /app

COPY composer.json composer.lock* ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --no-progress \
    --prefer-dist \
    --optimize-autoloader

# =============================================================================
# Stage 3: Final runtime image
# =============================================================================
FROM php:8.2-fpm-alpine AS runner

# Install system dependencies and PHP extensions
RUN apk add --no-cache \
    nginx \
    bash \
    curl \
    gettext \
    oniguruma-dev \
    # PHP extensions required by Laravel
    && docker-php-ext-install \
    bcmath \
    ctype \
    fileinfo \
    mbstring \
    pdo \
    pdo_mysql \
    # Clean up apk cache
    && rm -rf /var/cache/apk/* /tmp/*

# Copy Nginx configuration
COPY docker/nginx.conf /etc/nginx/nginx.conf

# Copy PHP-FPM configuration (override default pool config)
COPY docker/php-fpm.conf /usr/local/etc/php-fpm.d/zz-www.conf

WORKDIR /var/www/html

# 1. SALIN SOURCE CODE UTAMA TERLEBIH DAHULU (Ubah ownership ke www-data)
COPY --chown=www-data:www-data . /var/www/html/

# 2. TIMPA DENGAN DEPENDENSI BERSIH DARI MULTI-STAGE BUILD
COPY --from=composer-build --chown=www-data:www-data /app/vendor/ /var/www/html/vendor/
COPY --from=node-build --chown=www-data:www-data /app/public/build/ /var/www/html/public/build/

# Copy entrypoint script
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Create required directories and set strict permissions
RUN mkdir -p /var/www/html/storage/framework/cache/data \
    && mkdir -p /var/www/html/storage/framework/sessions \
    && mkdir -p /var/www/html/storage/framework/views \
    && mkdir -p /var/www/html/storage/logs \
    && mkdir -p /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/bootstrap/cache

# Clean up files not needed in production (Mempertahankan database/seeders untuk keperluan migrasi awal)
RUN rm -f /var/www/html/.env.example \
    /var/www/html/.env.production.example \
    /var/www/html/phpunit.xml \
    /var/www/html/README.md \
    /var/www/html/.editorconfig \
    /var/www/html/.gitattributes \
    /var/www/html/.htaccess \
    && rm -rf /var/www/html/tests \
    /var/www/html/database/factories

# Expose Railway's expected port
EXPOSE ${PORT:-8080}

# Health check to verify the app is running
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
    CMD curl -f http://localhost:${PORT:-8080}/up || exit 1

# Start the application
ENTRYPOINT ["/entrypoint.sh"]
