FROM bitnami/laravel

ARG ENV=production
ARG OPENAI_API_KEY

ENV APP_ENV=${ENV}
ENV OPENAI_API_KEY=${OPENAI_API_KEY}

WORKDIR /app

# Use official Composer binary for dependency installation
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

# Handle environment setup
RUN if [ -f .env.${ENV} ]; then \
    cp .env.${ENV} .env; \
    else \
    cp .env.example .env; \
    fi

# Install optimized production dependencies
RUN composer install --no-dev --optimize-autoloader

# Set correct permissions for Laravel
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
