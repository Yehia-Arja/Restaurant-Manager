FROM bitnami/laravel:latest

USER root

# Install system dependencies for WebSockets, queue, and OpenAI HTTP
RUN install_packages \
    autoconf \
    build-essential \
    pkg-config \
    gcc \
    make \
    libzip-dev \
    libssl-dev \
    zip \
    unzip \
    && pecl install redis \
    && docker-php-ext-install pdo_mysql sockets zip \
    && echo "extension=redis.so" > /opt/bitnami/php/etc/conf.d/redis.ini \
    && rm -rf /var/lib/apt/lists/*

# Copy composer files first for caching
COPY composer.json composer.lock /app/
WORKDIR /app

# Install PHP dependencies including WebSockets & Pusher packages
RUN composer require beyondcode/laravel-websockets pusher/pusher-php-server \
    && composer install --no-dev --optimize-autoloader

# Copy application code
COPY . /app
WORKDIR /app

# Set permissions
RUN mkdir -p storage/logs bootstrap/cache \
    && chown -R 1001:1001 storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

USER 1001

# Default command (you can override in compose)
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]