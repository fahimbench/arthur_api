#!/bin/bash
# Mise en production de l'API

echo "fahimbench Ded4ewb8kyh@" | git pull origin master
composer install --no-dev --optimize-autoloader
composer update --no-dev --optimize-autoloader
php bin/console doctrine:migrations:migrate
APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear