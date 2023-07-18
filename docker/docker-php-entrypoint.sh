#!/bin/sh
set -e

# If composer already autoloade
# then skip this process
if [ ! -f vendor/autoload.php ]; then
    composer update -w -no-progress --no-interaction
fi

# If user forgot to create env file then
# copy .env.example to .env
if [ ! -f ".env" ]; then
    echo "Creating env file for env $APP_ENV"
    cp .env.example .env
else
    echo "env file already exists"
fi

role=${CONTAINER_ROLE=-app}

if [ "$role" = "app" ]; then

    # Generate migration files
    php artisan migrate

    # Generate App keys
    php artisan key:generate

    # Clean app caches
    php artisan optimize:clear

    # Serve php on custom port
    php artisan serve --port=$PORT --host=0.0.0.0 --env=.env

    exec docker-php-entrypoint "$@"

elif [ "$role" = "queue" ]; then

    # Run queues
    echo "Running the queue ... "
    php artisan queue:work --verbose --tries=3 --timeout=1800

fi

# write the php-fpm config
{ \
    echo listen = /var/run/php-fpm.sock; \
    echo listen.owner = www-data; \
    echo listen.group = www-data; \
    echo pm.max_children = "$FPM_PM_MAX_CHILDREN"; \
    echo pm.start_servers = "$FPM_PM_START_SERVERS"; \
    echo pm.min_spare_servers = "$FPM_PM_MIN_SPARE_SERVERS"; \
    echo pm.max_spare_servers = "$FPM_PM_MAX_SPARE_SERVERS"; \
} > /usr/local/etc/php-fpm.d/zzz-app.conf

exec "$@"
