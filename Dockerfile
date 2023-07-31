
# Default to PHP 8.2, but we attempt to match
# the PHP version from the user (wherever `flyctl launch` is run)
# Valid version values are PHP 7.4+
# Usa la imagen oficial de PHP con Apache como base
FROM php:7.3-apache

# Configura el directorio de trabajo en el contenedor
WORKDIR /var/www/html

RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip unzip nano libzip-dev zip && docker-php-ext-configure zip && docker-php-ext-install zip

RUN docker-php-ext-install gd pdo pdo_mysql

# Habilita el módulo rewrite de Apache para usar .htaccess
RUN a2enmod rewrite

RUN chmod 777 -R -c /var/www

COPY  docker/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY  docker/.env-pro /var/www/html/.env
COPY  docker/apache2.conf /etc/apache2/

# Instala Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER 1

COPY composer.json composer.lock ./

COPY  . /var/www/html/

RUN chown -R www-data:www-data /var/www/html  \
    && composer install  && composer dumpautoload 
# Expone el puerto 80 para acceder al servidor web
EXPOSE 80

# Comando para iniciar el servidor web de Apache
CMD ["apache2-foreground"]


