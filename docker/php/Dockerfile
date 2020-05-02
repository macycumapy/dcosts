FROM php:7.4-fpm

RUN apt-get update && apt-get install -y wget git unzip \
        && pecl install xdebug-2.9.3 \
        && pecl install redis \
        && docker-php-ext-install pdo pdo_mysql \
        && docker-php-ext-enable xdebug redis
#    && chown -R www-data:www-data /var/www \
#    && chmod -R 775 /var/www/storage

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
