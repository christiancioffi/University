#!/bin/bash
while true
do
  echo "Pulizia in /var/www/html/uploads in corso...";
  find /var/www/html/uploads -type f,d -path '/var/www/html/uploads/*' -cmin +60 -delete;
  echo "Pulizia in /var/www/html/uploads effettuata";
  sleep 3600;
done
