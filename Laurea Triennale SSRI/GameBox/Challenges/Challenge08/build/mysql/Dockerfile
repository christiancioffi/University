FROM mysql:latest
USER root
RUN chmod 755 /var/lib/mysql
ADD ch8challenge.sql /docker-entrypoint-initdb.d
