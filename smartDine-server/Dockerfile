FROM bitnami/laravel:latest

USER root

# Install build tools needed for PECL Redis
RUN install_packages \
    autoconf \
    gcc \
    make \
    pkg-config

# Install PhpRedis extension
RUN pecl install redis \
    && echo "extension=redis.so" > /opt/bitnami/php/etc/conf.d/redis.ini

COPY . /app

WORKDIR /app

RUN composer install --no-interaction --prefer-dist

RUN chmod +x /app/shellScript.sh

USER 1001

CMD ["/app/shellScript.sh"]
