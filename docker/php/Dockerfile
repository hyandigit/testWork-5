FROM php:8.2-fpm-alpine

RUN apk update && apk add --no-cache \
    git \
    yarn \
    autoconf \
    g++ \
    make \
    openssl-dev

RUN docker-php-ext-install pdo pdo_mysql mysqli 
RUN docker-php-ext-install bcmath
RUN docker-php-ext-enable bcmath mysqli pdo_mysql

RUN apk add \
        libzip-dev \
        zip \
  && docker-php-ext-install zip

RUN apk add --no-cache \
    oniguruma-dev \
    && rm -rf /tmp/*

RUN docker-php-ext-install mbstring
RUN docker-php-ext-enable mbstring

    
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
ADD ./php.ini /usr/local/etc/php/php.ini
ADD ./xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini