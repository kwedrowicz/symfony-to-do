#!/bin/bash

php composer.phar install
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console hautelook:fixtures:load


service apache2 start

tail -f /var/log/apache2/project_access.log