FROM php:8.0 as php

# set composer related environment variables
ENV PATH="/composer/vendor/bin:$PATH" \
    COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_VENDOR_DIR=/var/www/vendor \
    COMPOSER_HOME=/composer

RUN apt-get update -y
RUN apt-get install -y unzip libpq-dev libcurl4-gnutls-dev
RUN docker-php-ext-install pdo pdo_mysql bcmath

RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer --ansi --version --no-interaction

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# add custom php-fpm pool settings, these get written at entrypoint startup
ENV FPM_PM_MAX_CHILDREN=20 \
    FPM_PM_START_SERVERS=2 \
    FPM_PM_MIN_SPARE_SERVERS=1 \
    FPM_PM_MAX_SPARE_SERVERS=3

# set application environment variables
ENV APP_NAME="Ndana_Shop_Management" \
    APP_ENV=production \
    APP_DEBUG=false

# install dos2unix
RUN apt-get update && \
    apt-get install dos2unix && \
    apt-get clean

# copy entrypoint files
COPY ./docker/docker-php-entrypoint.sh /usr/local/bin/
COPY ./docker/docker-php-entrypoint-dev.sh /usr/local/bin/

RUN dos2unix /usr/local/bin/docker-php-entrypoint.sh
RUN dos2unix /usr/local/bin/docker-php-entrypoint-dev.sh

# copy nginx configuration
COPY ./docker/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/default.conf /etc/nginx/conf.d/default.conf

# Set working directory
WORKDIR /var/www

# copy application code
COPY . .

# install application dependencies
COPY composer.json composer.json
COPY composer.lock composer.lock
RUN composer update -w --no-scripts --ansi --no-interaction
RUN composer dump-autoload -o

# Copy existing application directory permissions
COPY --chown=www:www . /var/www

# Change current user to www
USER www

RUN php artisan key:generate
RUN chmod 777 -R storage

EXPOSE 8000

# run supervisor
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisord.conf"]

# Node
FROM node:14-alpine as node

WORKDIR /var/www
COPY . .

RUN npm install -f -y --global cross-env
RUN npm install -f -y

VOLUME [ "/var/www/node_modules" ]
