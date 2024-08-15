FROM dunglas/frankenphp:php8.3 AS frankenphp

# Install PHP extensions using install-php-extensions
RUN install-php-extensions \
    pcntl \
    xdebug \
    redis
    # Add other PHP extensions here...

 # copy xdebug config
COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

#setting up composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

ENTRYPOINT ["php", "/app/artisan", "octane:frankenphp", "--workers=1", "--max-requests=1"]
