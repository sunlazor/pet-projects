FROM php:8.4-cli AS base

COPY --from=ghcr.io/mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions sockets zip curl

COPY --from=composer/composer:lts /usr/bin/composer /usr/bin/composer
WORKDIR /srv/www

COPY . .

#ENTRYPOINT composer install --no-interaction --no-progress && ./vendor/bin/rr get-binary && ./rr serve -c .rr.yaml
#ENTRYPOINT composer update --no-interaction --no-progress && ./rr serve -c .rr.yaml
#ENTRYPOINT composer update --no-interaction --no-progress && ./rr serve -c .rr.yaml
ENTRYPOINT ["./rr", "serve", "-c", ".rr.yaml"]