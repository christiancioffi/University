FROM mysql:latest
USER root
RUN chmod 755 /var/lib/mysql
ADD challenges.sql /docker-entrypoint-initdb.d
