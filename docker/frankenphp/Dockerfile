FROM dunglas/frankenphp:php8.3 AS frankenphp

# Install PHP extensions using install-php-extensions
RUN install-php-extensions \
    pcntl \
    xdebug \
    redis
    # Add other PHP extensions here...

# Install system dependencies
RUN apt-get update && apt-get install -y \
supervisor \
zip unzip

# copy xdebug config
COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Setting up supervisor
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

#setting up composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

ENTRYPOINT ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
