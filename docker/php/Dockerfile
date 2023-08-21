FROM php:8.2-fpm-alpine

RUN apk update --no-cache \
    && apk add --no-cache --virtual build-deps \
        libpq-dev \
    && apk add --no-cache \
        curl

RUN docker-php-ext-install pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    ln -s $(composer config --global home) /root/composer
ENV PATH=$PATH:/root/composer/vendor/bin COMPOSER_ALLOW_SUPERUSER=1

ADD php.ini /etc/php/conf.d/
ADD php.ini /etc/php/cli/conf.d/

WORKDIR /var/www/mercure-chat

EXPOSE 9000

CMD ["php-fpm", "-F"]
