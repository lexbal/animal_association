FROM php:7.4-fpm-alpine

RUN apk add --update --no-cache libgd libpng-dev libjpeg-turbo-dev freetype-dev

RUN docker-php-ext-install -j$(nproc) gd

ADD php.ini /usr/local/etc/php.ini