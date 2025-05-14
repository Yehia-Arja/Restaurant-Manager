FROM bitnami/laravel:latest

COPY . /app

WORKDIR /app

RUN install_packages autoconf

RUN pecl install redis \
    && echo "extension=redis.so" > /opt/bitnami/php/etc/conf.d/redis.ini

RUN composer install --no-interaction --prefer-dist

RUN chmod +x /app/shellScript.sh

CMD ["/app/shellScript.sh"]
