# Dockerfile

# 1. Base image
FROM bitnami/laravel:12.0.7-0

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

# 4. (Optional) Install Node.js if you build assets in-container
# RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash - \
#   && apt-get update \
#   && apt-get install -y nodejs

# 5. Switch back to non-root user
USER 1001

# 6. Set working directory
WORKDIR /app

# 7. Copy composer files & install dependencies
COPY composer.json composer.lock /app/
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# 8. Copy the rest of your application code
COPY . /app

# 9. Expose port and set default command
EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
