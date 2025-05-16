FROM bitnami/laravel:latest

USER root

# Install PHP build dependencies and phpredis
RUN apt-get update \
    && apt-get install -y unzip gcc make autoconf g++ libzip-dev \
    && pecl install redis \
    && echo "extension=redis.so" > /opt/bitnami/php/etc/conf.d/redis.ini \
    && rm -rf /var/lib/apt/lists/*

USER 1001

COPY . /app

WORKDIR /app

RUN composer install --no-interaction --prefer-dist

RUN chmod +x /app/shellScript.sh

CMD ["/app/shellScript.sh"]
