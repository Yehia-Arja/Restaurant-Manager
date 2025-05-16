FROM bitnami/laravel:latest

COPY . /app

WORKDIR /app

RUN composer install --no-interaction --prefer-dist

RUN chmod +x /app/shellScript.sh

CMD ["/app/shellScript.sh"]