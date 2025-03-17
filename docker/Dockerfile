FROM php:8.1-fpm

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/install-php-extensions

RUN apt-get update \
    && apt-get install -y \
        unzip \
        git \
    && apt-get clean all \
;

RUN install-php-extensions \
        bcmath \
        intl \
        zip \
;

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

COPY ./php/php.ini /usr/local/etc/php/

WORKDIR /var/www/html

CMD ["php-fpm"]