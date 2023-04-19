FROM mysql:latest
USER root
RUN chmod 755 /var/lib/mysql
ADD ch9challenge.sql /docker-entrypoint-initdb.d
