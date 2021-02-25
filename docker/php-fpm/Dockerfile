FROM php:7.4-fpm

RUN apt-get update

RUN apt-get install -y libzip-dev zlib1g-dev libpq-dev git libicu-dev libxml2-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && docker-php-ext-install zip xml

RUN curl --insecure https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer
RUN chown -R www-data:www-data /var/www
# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Berlin /etc/localtime
RUN "date"
# RUN php bin/console doctrine:mapping:import "App\Entity" annotation --path=src/Entity
# RUN php bin/console make:entity --regenerate App

WORKDIR /var/www/symfony
