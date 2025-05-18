FROM bitnami/laravel:latest

USER root

RUN apt-get update \
    && apt-get install -y unzip gcc make autoconf g++ libzip-dev \
    && pecl install redis \
    && echo "extension=redis.so" > /opt/bitnami/php/etc/conf.d/redis.ini \
    && rm -rf /var/lib/apt/lists/*

COPY . /app

RUN mkdir -p /app/vendor /app/storage/logs /app/bootstrap/cache \
    && chown -R 1001:1001 /app \
    && chmod -R 775 /app/storage /app/bootstrap/cache

USER 1001
WORKDIR /app

RUN composer install --no-interaction --prefer-dist


RUN chmod +x /app/shellScript.sh

CMD ["/app/shellScript.sh"]
