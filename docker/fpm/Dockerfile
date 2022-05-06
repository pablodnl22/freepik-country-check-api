FROM php:8.1-fpm

RUN apt update && apt install -y \
        zlib1g-dev \
        git \
        libpng-dev \
        libpq-dev \
        libxml2-dev \
        libzip-dev \
        libcurl4-openssl-dev \
        pkg-config \
        libssl-dev \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        zip \
        bcmath \
        soap \
        pcntl

COPY php.ini /usr/local/etc/php/php.ini
COPY www.conf /usr/local/etc/php-fpm.d/www.conf

