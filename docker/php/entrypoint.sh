#!/bin/sh

mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache storage/logs bootstrap/cache

chmod -R 777 storage bootstrap/cache storage

composer update -o --no-interaction

composer dump-autoload -o

php artisan migrate

php artisan optimize

php artisan event:cache

php artisan config:cache

php artisan route:cache

php artisan db:seed

php artisan init-elasticsearch-indices

vendor/bin/pint

npm install

php artisan octane:start --server=swoole --host=0.0.0.0 --port=9000 --max-requests=1000 --watch