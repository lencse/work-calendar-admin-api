FROM php:7.1-fpm

RUN apt-get update
RUN apt-get install -y libpq-dev
RUN docker-php-ext-install pdo_pgsql

#RUN apt-get install -y git zip
RUN curl --silent --show-error https://getcomposer.org/installer | php
RUN mv /var/www/html/composer.phar /usr/bin/composer
