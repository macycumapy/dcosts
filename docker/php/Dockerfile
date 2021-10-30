FROM php:8-fpm
RUN apt-get update && apt-get install -y wget git unzip libpq-dev \
        && pecl install xdebug redis \
        && docker-php-ext-install pdo pdo_pgsql pgsql\
        && docker-php-ext-enable xdebug redis
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
#RUN mkdir /var/www
VOLUME /var/www
WORKDIR /var/www
EXPOSE 8080