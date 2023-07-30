# Usa la imagen oficial de PHP con Apache como base
FROM php:7.3-apache

# Instala las dependencias necesarias
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip unzip nano

RUN docker-php-ext-install gd pdo pdo_mysql

COPY ./docker/apache2.conf /etc/apache2/apache2.conf

# Habilita el módulo rewrite de Apache para usar .htaccess
RUN a2enmod rewrite

RUN chmod 777 -R -c /var/www
