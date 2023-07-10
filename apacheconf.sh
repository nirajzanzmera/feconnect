#!/bin/bash
APACHE_SITES_DIR='/etc/apache2/sites-available'
ENV_FILE="/.env"

source "$ENV_FILE"

shopt -s nullglob

for file in `ls /sites-available/`
do
  sed "s/\$DOMAIN/$DOMAIN/g; s/\$API_KEY/$API_KEY/g" "/sites-available/$file" > "$APACHE_SITES_DIR/$file"
  a2ensite `basename $file .conf`
done

