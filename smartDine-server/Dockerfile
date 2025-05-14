FROM bitnami/laravel:latest

USER root

# Install required build tools to compile Redis via PECL
RUN install_packages \
    autoconf \
    build-essential \
    pkg-config \
    gcc \
    make

# Install PhpRedis via PECL
RUN pecl install redis \
    && echo "extension=redis.so" > /opt/bitnami/php/etc/conf.d/redis.ini

COPY . /app

WORKDIR /app

RUN composer install --no-interaction --prefer-dist

RUN chmod +x /app/shellScript.sh

USER 1001

CMD ["/app/shellScript.sh"]
