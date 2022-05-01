FROM php:7.4.29-fpm

RUN apt-get update && apt-get upgrade -y
RUN apt-get install apt-utils -y

RUN apt-get install libzip-dev libgmp-dev libffi-dev libssl-dev libxml2-dev wget -y
RUN docker-php-ext-install -j$(nproc) xml dom sockets zip gmp pcntl bcmath ffi gettext bcmath  \
    && docker-php-source delete \

RUN apt-get autoremove --purge -y && apt-get autoclean -y && apt-get clean -y
RUN wget https://phar.phpunit.de/phpunit-6.5.phar && \
        chmod +x phpunit-6.5.phar && \
        mv phpunit-6.5.phar /usr/local/bin/phpunit

RUN pecl install redis-5.3.7 && docker-php-ext-enable redis
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /avast
RUN chown www-data:www-data /avast
USER www-data