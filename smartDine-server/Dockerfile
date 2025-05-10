FROM bitnami/laravel:12.0.7-debian-12-r0

USER root

RUN install_packages --assume-yes git unzip php-zip php-redis php-mbstring php-xml php-curl php-bcmath php-intl && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts --prefer-dist

COPY . .
USER root

RUN mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache storage/logs && mkdir -p bootstrap/cache && chown -R 1001:1001 storage bootstrap/cache && chmod -R 775 storage bootstrap/cache

USER 1001
RUN composer dump-autoload --optimize --no-dev
EXPOSE 8000
CMD ["php","artisan","serve","--host=0.0.0.0","--port=8000"]
