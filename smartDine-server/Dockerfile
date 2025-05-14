FROM bitnami/laravel:latest

USER root

# Install required build tools to compile PhpRedis via PECL
RUN install_packages \
    autoconf \
    build-essential \
    pkg-config \
    gcc \
    make

# Install PhpRedis extension
RUN pecl install redis \
    && echo "extension=redis.so" > /opt/bitnami/php/etc/conf.d/redis.ini


COPY . /app
RUN rm -f .env && cp .env.example .env

WORKDIR /app


RUN composer install --no-interaction --prefer-dist

# Fix permissions for storage and cache
RUN mkdir -p storage/logs bootstrap/cache \
    && chown -R 1001:1001 storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Make the entry script executable
RUN chmod +x /app/shellScript.sh

# Drop to non-root user (Bitnami default)
USER 1001

# Launch Laravel
CMD ["/app/shellScript.sh"]
