#!/bin/bash
set -e # Exit immediately if a command exits with a non-zero status

echo "Docker Entrypoint: Starting application setup..."

# Ensure .env file exists and has APP_KEY
if [ ! -f /app/.env ]; then
    echo "Docker Entrypoint: .env file not found. Copying from .env.example..."
    cp /app/.env.example /app/.env
    
    echo "Docker Entrypoint: Setting APP_ENV=local and APP_DEBUG=true in new .env file..."
    # Ensure APP_ENV and APP_DEBUG are set for development visibility
    # These sed commands will replace the lines or add them if they don't exist (GNU sed specific behavior for -i without backup on some OS)
    # A more portable way if lines might be missing would be to check and append.
    if grep -q '^APP_ENV=' /app/.env; then
        sed -i 's/^APP_ENV=.*/APP_ENV=local/' /app/.env
    else
        echo "APP_ENV=local" >> /app/.env
    fi

    if grep -q '^APP_DEBUG=' /app/.env; then
        sed -i 's/^APP_DEBUG=.*/APP_DEBUG=true/' /app/.env
    else
        echo "APP_DEBUG=true" >> /app/.env
    fi
    
    echo "Docker Entrypoint: Generating APP_KEY..."
    php artisan key:generate --force # --force to ensure it runs if .env was just created
    echo "Docker Entrypoint: APP_KEY generated."
else
    echo "Docker Entrypoint: .env file already exists."
    # Check if APP_KEY is missing in an existing .env (less common but possible)
    if ! grep -q "^APP_KEY=" /app/.env || grep -q "^APP_KEY=$" /app/.env; then
        echo "Docker Entrypoint: APP_KEY is missing or empty in existing .env. Generating..."
        php artisan key:generate --force
        echo "Docker Entrypoint: APP_KEY generated."
    fi
fi

echo "Docker Entrypoint: Clearing Laravel's configuration cache..."
php artisan config:clear
# You might also consider: php artisan route:clear; php artisan view:clear;
echo "Docker Entrypoint: Configuration cache cleared."

echo "Docker Entrypoint: Waiting for MySQL database at host '${DB_HOST}' on port '${DB_PORT:-3306}' for database '${DB_DATABASE}'..."
max_attempts=30
attempt_num=1
# Use getenv() in PHP for environment variables passed by docker-compose
until php -r "try { new PDO('mysql:host=' . getenv('DB_HOST') . ';port=' . (getenv('DB_PORT') ?: '3306') . ';dbname=' . getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'), [PDO::ATTR_TIMEOUT => 2]); exit(0); } catch (PDOException \$e) { echo 'PDO Error: ' . \$e->getMessage() . PHP_EOL; exit(1); }" >/dev/null 2>&1; do
    if [ ${attempt_num} -ge ${max_attempts} ]; then
        echo "Docker Entrypoint: Failed to connect to MySQL after $max_attempts attempts. Exiting."
        exit 1
    fi
    echo "Docker Entrypoint: MySQL is unavailable - sleeping (attempt ${attempt_num}/${max_attempts})"
    sleep 3 # Increased sleep slightly
    attempt_num=$((attempt_num+1))
done
echo "Docker Entrypoint: MySQL database is ready."

echo "Docker Entrypoint: Running database migrations..."
php artisan migrate --force # --force is good for non-interactive environments
echo "Docker Entrypoint: Database migrations completed."

echo "Docker Entrypoint: Starting Laravel development server on 0.0.0.0:8000..."
# exec replaces the shell process with the PHP server, which is good.
exec php artisan serve --host=0.0.0.0 --port=8000