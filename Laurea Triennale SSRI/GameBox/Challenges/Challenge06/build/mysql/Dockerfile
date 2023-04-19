FROM mysql:latest
USER root
RUN chmod 755 /var/lib/mysql
ADD ch6challenge.sql /docker-entrypoint-initdb.d
