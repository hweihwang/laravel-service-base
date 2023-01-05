#!/bin/sh

composer update -o --no-interaction

mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache storage/logs bootstrap/cache

chmod -R 777 storage bootstrap/cache storage

composer dump-autoload -o

php artisan config:cache

php artisan octane:install --server=swoole

npm install

php artisan telescope:install

php artisan migrate

php artisan optimize

php artisan event:cache

php artisan config:cache

php artisan route:cache

php artisan octane:stop

php artisan init-elasticsearch-indices

vendor/bin/pint

php artisan octane:start --server=swoole --host=0.0.0.0 --port=9000 --max-requests=1000 --watch