FROM php:8.4-cli AS base

COPY --from=ghcr.io/mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions sockets zip curl

COPY --from=composer/composer:lts /usr/bin/composer /usr/bin/composer
WORKDIR /srv/www

COPY . .

ENTRYPOINT composer install --no-interaction --no-progress && ./vendor/bin/rr get-binary && rr serve -c .rr.yaml
#RUN --mount=type=bind,rw=true,src=.,dst=/srv/www \
#  composer install --no-interaction --no-progress
#
#RUN ./vendor/bin/rr get-binary
#
#
#
#CMD rr serve -c .rr.yaml




#FROM php:8.4-cli AS base
#
#COPY --from=ghcr.io/mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
#RUN install-php-extensions sockets zip curl
#
#COPY --from=composer/composer:lts /usr/bin/composer /usr/bin/composer
#WORKDIR /srv/www
#
#RUN --mount=type=bind,rw=true,src=.,dst=/srv/www \
#  composer install --no-interaction --no-progress
#
#RUN ./vendor/bin/rr get-binary
#
#
#
#CMD rr serve -c .rr.yaml

#FROM ghcr.io/roadrunner-server/roadrunner:2025.1 AS roadrunner
#FROM php:8.4-cli
#
#COPY --from=roadrunner /usr/bin/rr /usr/local/bin/rr
#
#COPY --from=ghcr.io/mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
#RUN install-php-extensions sockets zip
#
#WORKDIR /srv/www
#
#COPY composer.* ./
#
#COPY --from=composer/composer:lts /usr/bin/composer /usr/bin/composer
#RUN composer update --no-interaction --no-progress
#
#COPY . .
#
##CMD rr serve -c .rr.yaml
#RUN bash