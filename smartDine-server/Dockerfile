# Dockerfile

# 1. Base image (matches Docker Hub tag)
FROM bitnami/laravel:12.0.7-debian-12-r0

# 2. Switch to root to install extra packages
USER root

# 3. Install system packages and PHP extensions (zip, redis, git)
RUN install_packages --assume-yes \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip \
    && pecl install redis \
    && docker-php-ext-enable redis

# 4. Switch back to non-root user
USER 1001

# 5. Set working directory
WORKDIR /app

# 6. Copy composer files & install dependencies
COPY composer.json composer.lock /app/
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# 7. Copy the rest of your application code
COPY . /app

# 8. Expose port and set default command
EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
