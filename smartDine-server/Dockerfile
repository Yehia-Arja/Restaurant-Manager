# 1) Base image must exactly match your tag
FROM bitnami/laravel:12.0.7-debian-12-r0

# 2) Switch to root to install extra OS packages
USER root

# 3) Install git, unzip + PHP extensions, then clean up
RUN install_packages --assume-yes \
    git \
    unzip \
    php-zip \
    php-redis \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# 4) Switch back to non-root user for security
USER 1001

# 5) Set your app directory
WORKDIR /app

# 6) Layer-cache your composer install
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist

# 7) Copy the rest of your code
COPY . .

# 8) Expose port and run Laravel’s built-in server
EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
