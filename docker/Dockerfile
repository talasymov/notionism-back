FROM php:8.1-fpm-buster

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libicu-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    vim \
    unzip \
    libzip-dev \
    zip \
    curl \
    libyaml-dev

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN pecl install -o -f redis yaml \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis yaml

RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

# Install extensions
RUN docker-php-ext-install pdo_mysql sockets zip intl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
