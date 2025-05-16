FROM bitnami/laravel:12.0.7-debian-12-r0

USER root
WORKDIR /app

RUN apt-get update \
    && apt-get install -y unzip gcc make autoconf g++ libzip-dev \
    && pecl install redis \
    && mkdir -p /opt/bitnami/php/etc/conf.d \
    && echo "extension=redis.so" > /opt/bitnami/php/etc/conf.d/redis.ini \
    && rm -rf /var/lib/apt/lists/*


COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts


COPY . .


RUN php artisan key:generate --force \
    && php artisan package:discover --ansi \
    && php artisan config:cache \
    && php artisan route:cache


RUN chown -R 1001:1001 /app/storage /app/bootstrap/cache

USER 1001
EXPOSE 8000
CMD ["php","artisan","serve","--host=0.0.0.0","--port=8000"]

# Default command
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]