#!/bin/bash

php artisan key:generate --force


php artisan config:clear
php artisan config:cache

# Migrate
php artisan migrate --force

# Start Laravel
php artisan serve --host=0.0.0.0 --port=8000
