FROM php:7.1-fpm

RUN apt-get update && apt-get install -y libpq-dev
RUN docker-php-ext-install pdo_pgsql

# dev:ls
RUN apt-get update && apt-get install -y git zip
RUN curl --silent --show-error https://getcomposer.org/installer | php
RUN mv /var/www/html/composer.phar /usr/bin/composer


RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini
