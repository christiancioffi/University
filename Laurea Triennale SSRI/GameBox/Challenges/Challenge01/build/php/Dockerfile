FROM php:8.1-apache
RUN apt-get update && \
    docker-php-ext-install mysqli pdo pdo_mysql
RUN chmod o-t /var/tmp
RUN chmod o+x /var/tmp
COPY app /var/www/html
COPY config_files/php.ini /usr/local/etc/php/php.ini
COPY config_files/hosts /etc/hosts
COPY config_files/apache2.conf /etc/apache2/apache2.conf
COPY config_files/ports.conf /etc/apache2/ports.conf
COPY config_files/mycert.key /etc/ssl/private/mycert.key
COPY config_files/mycert.crt /etc/ssl/certs/mycert.crt
COPY config_files/default-ssl.conf /etc/apache2/sites-available/default-ssl.conf
COPY config_files/default-ssl.conf /etc/apache2/sites-enabled/default-ssl.conf
COPY scripts /var/scripts
RUN apt-get update && apt-get install -y \
   python3-pip
RUN pip install --upgrade pip
RUN pip install -r /var/scripts/requirements.txt
ENTRYPOINT ["/var/scripts/start.sh"]
