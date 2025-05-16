FROM bitnami/laravel:latest

# Use root to install dependencies + fix permissions
USER root

# Install Redis extension + system deps
RUN apt-get update \
    && apt-get install -y unzip gcc make autoconf g++ libzip-dev \
    && pecl install redis \
    && echo "extension=redis.so" > /opt/bitnami/php/etc/conf.d/redis.ini \
    && rm -rf /var/lib/apt/lists/*

# Copy app before setting ownership
COPY . /app

# Fix permissions for Bitnami's default user (1001)
RUN mkdir -p /app/vendor /app/storage/logs /app/bootstrap/cache \
    && chown -R 1001:1001 /app \
    && chmod -R 775 /app/storage /app/bootstrap/cache

# Switch to non-root user
USER 1001

WORKDIR /app

RUN composer install --no-interaction --prefer-dist

RUN chmod +x /app/shellScript.sh

CMD ["/app/shellScript.sh"]
