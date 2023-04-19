FROM mysql:latest
USER root
RUN chmod 755 /var/lib/mysql
ADD ch4challenge.sql /docker-entrypoint-initdb.d
