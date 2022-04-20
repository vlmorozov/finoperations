FROM library/php:8.1-cli

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR "/app"
