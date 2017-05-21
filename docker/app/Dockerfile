FROM php:7.1-apache
COPY config/php.ini /usr/local/etc/php/

RUN apt-get update && apt-get install -y git \
    zip \
    unzip \
    varnish

RUN docker-php-ext-install pdo pdo_mysql
COPY site.conf /etc/apache2/sites-available/site.conf
RUN a2enmod rewrite
RUN a2ensite site.conf
COPY run.sh /run.sh
COPY config/default.vcl /etc/varnish/default.vcl

WORKDIR /code
EXPOSE 80 443 6081

CMD ["/bin/bash", "/run.sh"]