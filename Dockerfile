# =============================================================================
# Stage 1: Build frontend assets with Node
# =============================================================================
FROM node:20-alpine AS node-build

WORKDIR /app

# Install dependencies first (for better caching)
COPY package.json ./
RUN npm ci --no-audit --no-fund

# Copy source and build
COPY postcss.config.js tailwind.config.js vite.config.js ./
COPY resources/ resources/
RUN npm run build

# =============================================================================
# Stage 2: Install Composer dependencies
# =============================================================================
FROM composer:2 AS composer-build

WORKDIR /app

COPY composer.json ./
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
    # Nginx and utilities
    nginx \
    bash \
    curl \
    gettext \
    # PHP extensions required by Laravel
    && docker-php-ext-install \
    bcmath \
    ctype \
    fileinfo \
    pdo \
    pdo_mysql \
    # Clean up
    && rm -rf /var/cache/apk/* /tmp/*

# Install mbstring (built-in but ensure it's enabled)
RUN docker-php-ext-install mbstring

# Copy Nginx configuration
COPY docker/nginx.conf /etc/nginx/nginx.conf

# Copy PHP-FPM configuration (override default pool config)
COPY docker/php-fpm.conf /usr/local/etc/php-fpm.d/zz-www.conf

# Copy from composer stage
COPY --from=composer-build /app/vendor/ /var/www/html/vendor/

# Copy from node build stage
COPY --from=node-build /app/public/build/ /var/www/html/public/build/

# Copy application source
COPY . /var/www/html/

# Copy entrypoint script
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Create required directories and set permissions
RUN mkdir -p /var/www/html/storage/framework/cache/data \
    && mkdir -p /var/www/html/storage/framework/sessions \
    && mkdir -p /var/www/html/storage/framework/views \
    && mkdir -p /var/www/html/storage/logs \
    && mkdir -p /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/bootstrap/cache

# Clean up files not needed in production
RUN rm -f /var/www/html/.env.example \
    /var/www/html/.env.production.example \
    /var/www/html/phpunit.xml \
    /var/www/html/README.md \
    /var/www/html/.editorconfig \
    /var/www/html/.gitattributes \
    /var/www/html/.htaccess \
    && rm -rf /var/www/html/tests \
    /var/www/html/database/factories \
    /var/www/html/database/seeders

# Expose Railway's expected port
EXPOSE ${PORT:-8080}

WORKDIR /var/www/html

# Health check to verify the app is running
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
    CMD curl -f http://localhost:${PORT:-8080}/up || exit 1

# Start the application
ENTRYPOINT ["/entrypoint.sh"]
