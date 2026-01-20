FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    git zip unzip libpq-dev libxml2-dev

# ставим нужные расширения PHP
RUN docker-php-ext-install pdo pdo_pgsql xml dom

WORKDIR /var/www/html

COPY . .

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
 && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
 && rm composer-setup.php

#RUN composer install

CMD ["php-fpm"]
