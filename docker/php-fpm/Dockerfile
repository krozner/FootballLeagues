FROM php:7.2.6-fpm
WORKDIR /var/www/app

RUN apt-get update
RUN apt-get install --yes git
RUN apt-get install --yes zip

RUN docker-php-ext-install pdo pdo_mysql

# xdebug PHP extension
RUN pecl install pecl install xdebug \
    && docker-php-ext-enable xdebug

# Install opcache
#RUN docker-php-ext-install opcache
# Install APCu
RUN pecl install apcu
RUN echo "extension=apcu.so" > /usr/local/etc/php/conf.d/apcu.ini

# intl PHP extension
RUN apt-get install --yes libicu-dev
RUN docker-php-ext-install intl

#RUN apt-get install --yes libxml2-dev
#RUN docker-php-ext-install soap

# Install selected extensions and other stuff
#RUN apt-get update \
#    && apt-get -y --no-install-recommends install  php7.2-mysql
#
## Install git
#RUN apt-get update \
#    && apt-get -y install git

RUN curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=/usr/bin/ --filename=composer