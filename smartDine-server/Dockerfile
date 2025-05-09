# 1) Base image
FROM bitnami/laravel:12.0.7-debian-12-r0

# 2) Become root to install OS & PHP extension packages
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

# 3) Copy just the files needed for Composer layer & post-autoload scripts
COPY composer.json composer.lock ./
COPY artisan ./
COPY bootstrap bootstrap

# 4) Create the cache dir and make it writable
RUN mkdir -p bootstrap/cache \
    && chmod -R 775 bootstrap/cache

# 5) Install PHP dependencies (this will successfully run package:discover)
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist

# 6) Copy the rest of your application
COPY . .

# 7) Ensure storage & cache are writable, then chown everything to user 1001
RUN chmod -R 775 storage bootstrap/cache \
    && chown -R 1001:1001 .

# 8) Switch back to the non-root user
USER 1001

# 9) Expose port & run
EXPOSE 8000
CMD ["php","artisan","serve","--host=0.0.0.0","--port=8000"]
