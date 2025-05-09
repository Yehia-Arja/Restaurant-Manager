FROM bitnami/laravel:12.0.7-debian-12-r0
USER root

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

# 1) Copy lockfiles for layer caching
COPY composer.json composer.lock ./

# 2) Copy files needed by post-autoload scripts
COPY artisan ./
COPY bootstrap bootstrap

# 3) Now install dependencies (post-autoload will find artisan)
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist

# 4) Copy the rest of your app
COPY . .

EXPOSE 8000
CMD ["php","artisan","serve","--host=0.0.0.0","--port=8000"]
