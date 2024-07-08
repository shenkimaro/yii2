# Use a imagem base do PHP 7.1
FROM php:7.1-fpm

RUN apt-get update && \
    apt-get install -y libpq-dev  \
    zlib1g-dev  \
    htop  && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install mysqli pdo_mysql zip

COPY composer.phar /usr/local/bin/composer

RUN ["chmod", "+x", "/usr/local/bin/composer"]

RUN mdir /var/www/uploads/

RUN ["chmod", "777", "/var/www/uploads/"]
