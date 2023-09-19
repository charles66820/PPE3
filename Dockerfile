FROM composer:1.4 as composer
FROM php:7.2-apache

ARG WEB_USER=www-data
ARG WEB_PRJ_DIR=/var/www/prj/
ARG SERVER_NAME=www.example.com
ARG SERVER_ADMIN=webmaster@localhost

RUN apt-get update
RUN apt-get install -y git zip libzip-dev zlib1g-dev
#unzip

# Install php extensions
RUN docker-php-ext-configure zip --with-libzip
RUN docker-php-ext-install pdo pdo_mysql zip

# Configure apache2
RUN sed -ri -e "s!/var/www/html!${WEB_PRJ_DIR}public\n\n<Directory ${WEB_PRJ_DIR}public>\nAllowOverride All\nOrder Allow,Deny\nAllow from All\n</Directory>!g" /etc/apache2/sites-available/000-default.conf
RUN sed -ri -e "s!#ServerName www.example.com!ServerName $SERVER_NAME!g" /etc/apache2/sites-available/000-default.conf
RUN sed -ri -e "s!ServerAdmin webmaster@localhost!ServerAdmin $SERVER_ADMIN!g" /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite

# Install Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Copy projet and start composer install (vendor install)
USER ${WEB_USER}
COPY --chown=${WEB_USER}:${WEB_USER} . ${WEB_PRJ_DIR}
WORKDIR ${WEB_PRJ_DIR}
RUN COMPOSER_CACHE_DIR=${WEB_PRJ_DIR}.composer composer install --optimize-autoloader --no-scripts
# --no-dev

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
