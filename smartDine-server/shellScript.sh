#!/bin/bash


if [ -z "$APP_KEY" ]; then
  echo "APP_KEY is missing, generating one..."
  php artisan key:generate --force
else
  echo "APP_KEY found in environment."
fi

php artisan config:clear
php artisan config:cache

php artisan migrate --force
php artisan serve --host=0.0.0.0 --port=8000
