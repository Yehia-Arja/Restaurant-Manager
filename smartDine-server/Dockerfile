FROM bitnami/laravel:latest

USER root

# Install PhpRedis
RUN install_packages \
    autoconf \
    build-essential \
    pkg-config \
    gcc \
    make \
    && pecl install redis \
    && echo "extension=redis.so" > /opt/bitnami/php/etc/conf.d/redis.ini

# Copy project files
COPY . /app
WORKDIR /app

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist

# Fix permissions for Laravel
RUN mkdir -p storage/logs bootstrap/cache \
    && chown -R 1001:1001 storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

USER 1001
