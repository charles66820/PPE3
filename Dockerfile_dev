FROM php:7.2-apache

# Debian dep
RUN apt-get update
RUN apt-get install -y vim git libzip-dev zlib1g-dev zip unzip nano

# Install php extensions
RUN docker-php-ext-configure zip --with-libzip
RUN docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR .
# Bashrc
RUN rm /root/.bashrc
COPY .docker/.bashrc /root/.bashrc

# Conf Apache2
RUN a2enmod rewrite
RUN service apache2 restart

# EXPOSE 80

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
