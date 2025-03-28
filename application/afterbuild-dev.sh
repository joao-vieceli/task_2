#!/bin/bash

cd /var/www/html

chown -R www-data:www-data /var/www/html
chmod -R 777 /var/www/html

cp .env.example .env

npm install

composer install

php artisan key:generate

php artisan migrate:fresh

npm run dev & php artisan serve --host=0.0.0.0
