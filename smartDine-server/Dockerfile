FROM bitnami/laravel:latest

USER root

# Install system packages + Redis extension
RUN apt-get update \
    && apt-get install -y unzip gcc make autoconf g++ libzip-dev \
    && pecl install redis \
    && echo "extension=redis.so" > /opt/bitnami/php/etc/conf.d/redis.ini \
    && rm -rf /var/lib/apt/lists/*

# Copy all code BEFORE permissions
COPY . /app

# Fix permissions aggressively
RUN mkdir -p /app/storage/logs /app/bootstrap/cache \
    && chown -R www-data:www-data /app \
    && chmod -R 775 /app/storage /app/bootstrap/cache

# Switch to safer user
USER 1001

WORKDIR /app

# Now install packages safely
RUN composer install --no-interaction --prefer-dist

RUN chmod +x /app/shellScript.sh

CMD ["/app/shellScript.sh"]
