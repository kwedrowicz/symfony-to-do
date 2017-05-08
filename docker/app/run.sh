#!/bin/bash

HTTPDUSER=`ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX var
setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX var

php composer.phar install
php bin/console doctrine:migrations:migrate
php bin/console doctrine:schema:create --env=test
php bin/console hautelook:fixtures:load

service apache2 start

tail -f /var/log/apache2/project_access.log