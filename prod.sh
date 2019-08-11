#!/bin/bash
# Mise en production de l'API

git config credential.helper store
git pull origin master
composer i -o
composer u -o
sed -i 's/\(APP_ENV=\)\(.*\)/\1prod/' .env
sed -i 's/\(DATABASE_URL=\)\(.*\)/\1mysql:\/\/fahim:arigato@@..@127.0.0.1:3306\/arthurapidb/' .env
if [ ! -d /var/lib/mysql/arthurapidb ]; then
  php bin/console doctrine:database:create
fi
yes Y | php bin/console doctrine:migrations:migrate
APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear