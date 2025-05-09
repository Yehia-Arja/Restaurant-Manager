FROM bitnami/laravel:12.0.7-debian-12-r0
USER root

# install OS tools + all the PHP extensions Laravel needs
RUN install_packages --assume-yes \
    git \
    unzip \
    php-zip \
    php-redis \
    php-mbstring \
    php-xml \
    php-curl \
    php-bcmath \
    php-intl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

USER 1001
WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist

COPY . .

EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
