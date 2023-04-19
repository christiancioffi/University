FROM mysql:latest
USER root
RUN chmod 755 /var/lib/mysql
ADD ch3challenge.sql /docker-entrypoint-initdb.d
ADD ch3_user_setup.sql /docker-entrypoint-initdb.d
