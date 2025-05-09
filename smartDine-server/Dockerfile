# 1) Base on your exact Bitnami tag
FROM bitnami/laravel:12.0.7-debian-12-r0

# 2) Install extra extensions & tools as root
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

WORKDIR /app

# 3) Copy only lockfiles first (for layer caching)
COPY composer.json composer.lock ./

# 4) Install PHP deps, but skip scripts so we don't need artisan/routes yet
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts \
    --prefer-dist

# 5) Now pull in the rest of your application
COPY . .

# 6) Prep cache/storage & run discovery
USER root
RUN mkdir -p bootstrap/cache storage \
    && chmod -R 775 bootstrap/cache storage

# 7) Now that artisan, routes, etc. are here, run package discovery
RUN composer run-script post-autoload-dump

# 8) Switch back to non-root for runtime
USER 1001

EXPOSE 8000
CMD ["php","artisan","serve","--host=0.0.0.0","--port=8000"]
