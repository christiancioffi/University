FROM php:8.1-apache

RUN apt-get update && \
    docker-php-ext-install mysqli pdo pdo_mysql
RUN chmod o-t /var/tmp
RUN chmod o+x /var/tmp
COPY app /var/www/html
COPY config_files/php.ini /usr/local/etc/php/php.ini
COPY config_files/hosts /etc/hosts
COPY config_files/apache2.conf /etc/apache2/apache2.conf
COPY config_files/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY config_files/000-default.conf /etc/apache2/sites-enabled/000-default.conf
COPY config_files/ports.conf /etc/apache2/ports.conf
