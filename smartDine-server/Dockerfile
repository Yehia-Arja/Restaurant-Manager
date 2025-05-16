FROM bitnami/laravel:latest

USER root

# Install PHP build dependencies and phpredis
RUN apt-get update \
    && apt-get install -y unzip gcc make autoconf g++ libzip-dev \
    && pecl install redis \
    && echo "extension=redis.so" > /opt/bitnami/php/etc/conf.d/redis.ini \
    && rm -rf /var/lib/apt/lists/*

# Copy all files
COPY . /app

# Fix permissions as root
RUN mkdir -p /app/storage/logs /app/bootstrap/cache \
    && chmod -R 775 /app/storage /app/bootstrap/cache \
    && chown -R www-data:www-data /app/storage /app/bootstrap/cache

USER 1001

WORKDIR /app

# Install dependencies
RUN composer install --no-interaction --prefer-dist

# Make script executable
RUN chmod +x /app/shellScript.sh

CMD ["/app/shellScript.sh"]
