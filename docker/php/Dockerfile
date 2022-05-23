FROM php:8.1-fpm-alpine

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN  set -ex && \
    apk --no-cache add --no-cache \
    libffi-dev \
    postgresql-dev \
    libzip-dev \
    icu-dev \
    librdkafka-dev

RUN docker-php-source extract \
    && docker-php-ext-install intl opcache pdo pdo_pgsql \
    && apk add --no-cache --virtual .phpize-deps-configure $PHPIZE_DEPS \
    && pecl install apcu-5.1.21 \
    && pecl install rdkafka-6.0.1 \
    && pecl install redis-5.3.7 \
	&& pecl install xdebug-3.1.4 \
    && docker-php-ext-enable apcu rdkafka redis xdebug \
    && apk del .phpize-deps-configure \
    && docker-php-source delete


ADD --chown=82:82 ./composer.json /var/www/application/composer.json
ADD --chown=82:82 ./composer.lock /var/www/application/composer.lock

WORKDIR /var/www/application/

RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

ADD --chown=82:82 ./ /var/www/application/
