FROM php:8.2.1RC1-cli-alpine3.17

ENV COMPOSER_ALLOW_SUPERUSER 1

WORKDIR /var/www/html

RUN apk add --no-cache \
    php81-dev npm \
    g++ make \
    bash nano \
    && pecl install swoole-5.0.1 \
    && docker-php-ext-enable swoole \
    && docker-php-ext-install pdo pdo_mysql \
    && apk del g++ make \
    && rm -rf /tmp/*

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

COPY /docker/php/config/php.ini /usr/local/etc/php/php.ini

COPY /docker/php/config/error_reporting.ini /usr/local/etc/php/conf.d/error_reporting.ini

COPY /docker/php/entrypoint.sh /entrypoint.sh

RUN chmod +x /entrypoint.sh

EXPOSE 9000

ENTRYPOINT ["/entrypoint.sh"]