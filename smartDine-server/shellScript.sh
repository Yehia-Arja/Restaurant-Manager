
cp .env
php artisan key:generate
php artisan config:clear
php artisan migrate --force

php artisan serve --host=0.0.0.0 --port=8000