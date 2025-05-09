# 1) Base image
FROM bitnami/laravel:12.0.7-debian-12-r0

# 2) Install extra PHP extensions and tools
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

# 3) Switch back to non-root
USER 1001
WORKDIR /app

# 4) Copy lockfiles for caching
COPY composer.json composer.lock ./

# 5) Copy artisan & bootstrap so post-autoload scripts find them
COPY artisan ./
COPY bootstrap ./bootstrap

# 6) Ensure bootstrap/cache exists and is writable
RUN mkdir -p bootstrap/cache \
    && chmod -R ug+rwx bootstrap/cache

# 7) Install PHP dependencies (will now detect artisan & cache dir)
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist

# 8) Copy the rest of your app code
COPY . .

# 9) Expose & serve
EXPOSE 8000
CMD ["php","artisan","serve","--host=0.0.0.0","--port=8000"]
