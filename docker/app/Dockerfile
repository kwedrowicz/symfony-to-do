FROM php:7.1-apache

RUN apt-get update && apt-get install -y git \
    zip \
    unzip

RUN docker-php-ext-install pdo pdo_mysql
COPY site.conf /etc/apache2/sites-available/site.conf
RUN a2enmod rewrite
RUN a2ensite site.conf
COPY run.sh /run.sh

WORKDIR /code
EXPOSE 80 443

CMD ["/bin/bash", "/run.sh"]