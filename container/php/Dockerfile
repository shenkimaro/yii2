# Use a imagem base do PHP 7.1
FROM php:7.1-fpm

RUN apt-get update && \
    apt-get install -y libpq-dev && \
    apt-get install -y zlib1g-dev && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install mysqli pdo_mysql zip

# RUN curl -sS https://getcomposer.org/installer  | php

COPY composer.phar /usr/local/bin/composer

#RUN cd /var/www/html/ 
#RUN composer create-project --prefer-dist yiisoft/yii2-app-basic basic