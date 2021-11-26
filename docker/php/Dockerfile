FROM php:7.4-fpm-alpine

LABEL maintainer="Rodrigo Cabral <rbatista.ti@gmail.com>"

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_PROCESS_TIMEOUT 900
ENV COMPOSER_DISABLE_XDEBUG_WARN=1

RUN apk update
RUN apk add wget

RUN apk add --no-cache --virtual .phpize_deps $PHPIZE_DEPS

RUN apk --no-cache add postgresql-dev
RUN docker-php-ext-install pgsql

RUN docker-php-ext-install pdo
RUN docker-php-ext-install pdo_pgsql

RUN apk add libc-dev

RUN echo "@v3.4 http://nl.alpinelinux.org/alpine/v3.4/main" >> /etc/apk/repositories && \
    apk update && \
    apk add --no-cache "postgresql-client@v3.4>=9.5"

RUN apk add postgresql-client

RUN apk add jq git

RUN ln -s /var/www/app/artisan /usr/local/bin/artisan

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer self-update

RUN apk del .phpize_deps
