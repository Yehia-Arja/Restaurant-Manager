FROM bitnami/laravel:latest

USER root

# Install PHP build dependencies and phpredis
RUN apt-get update \
    && apt-get install -y unzip gcc make autoconf g++ libzip-dev \
    && pecl install redis \
    && echo "extension=redis.so" > /opt/bitnami/php/etc/conf.d/redis.ini \
    && rm -rf /var/lib/apt/lists/*

USER 1001

# Copy project files with correct permissions
COPY --chown=bitnami:daemon . /app

WORKDIR /app

# Create folders and fix permissions early
RUN mkdir -p storage/logs bootstrap/cache \
    && chmod -R ug+rwX storage bootstrap/cache \
    && chmod -R ug+rwX /app \
    && chown -R bitnami:daemon storage bootstrap/cache

# Install dependencies
RUN composer install --no-interaction --prefer-dist

# Make the shell script executable
RUN chmod +x /app/shellScript.sh

CMD ["/app/shellScript.sh"]
