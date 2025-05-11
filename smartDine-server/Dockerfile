FROM bitnami/laravel:12.0.7-debian-12-r0

USER root

# Install dependencies and PHP extensions
RUN install_packages \
    git \
    unzip \
    php-zip \
    php-mbstring \
    php-xml \
    php-curl \
    php-bcmath \
    php-intl \
    php-mysql \
    autoconf \
    build-essential \
    pkg-config \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install PhpRedis manually via PECL
RUN pecl install redis \
    && echo "extension=redis.so" > /opt/bitnami/php/etc/conf.d/redis.ini

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --optimize-autoloader --no-interaction --no-scripts --prefer-dist

COPY . .

RUN mkdir -p storage/framework/{sessions,views,cache} \
    storage/logs \
    bootstrap/cache \
    && chown -R 1001:1001 storage bootstrap/cache vendor \
    && chmod -R 775 storage bootstrap/cache \
    && composer dump-autoload --optimize --no-scripts

USER 1001

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
