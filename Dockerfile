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

# install application dependencies
WORKDIR /var/www/app
COPY ./composer.json ./composer.lock* ./
RUN composer update --no-scripts --no-autoloader --ansi --no-interaction --ignore-platform-reqs

# add custom php-fpm pool settings, these get written at entrypoint startup
ENV FPM_PM_MAX_CHILDREN=20 \
    FPM_PM_START_SERVERS=2 \
    FPM_PM_MIN_SPARE_SERVERS=1 \
    FPM_PM_MAX_SPARE_SERVERS=3

# set application environment variables
ENV APP_NAME="Question Board" \
    APP_ENV=production \
    APP_DEBUG=false

# copy entrypoint files
RUN apt-get update && \
    apt-get install dos2unix && \
    apt-get clean

COPY ./docker/docker-php-entrypoint.sh /usr/local/bin/
COPY ./docker/docker-php-entrypoint-dev.sh /usr/local/bin/

RUN dos2unix /usr/local/bin/docker-php-entrypoint.sh
RUN dos2unix /usr/local/bin/docker-php-entrypoint-dev.sh

# copy nginx configuration
COPY ./docker/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/default.conf /etc/nginx/conf.d/default.conf

# copy application code
WORKDIR /var/www/app
COPY . .
RUN composer dump-autoload -o \
    && chown -R :www-data /var/www/app \
    && chmod -R 775 /var/www/app/storage /var/www/app/bootstrap/cache

EXPOSE 80

# run supervisor
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisord.conf"]

# Node
FROM node:14-alpine as node

WORKDIR /var/www
COPY . .

RUN npm install -f -y --global cross-env
RUN npm install -f -y

VOLUME [ "/var/www/node_modules" ]
