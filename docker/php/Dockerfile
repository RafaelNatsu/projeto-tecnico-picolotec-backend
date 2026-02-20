FROM php:8.3-fpm-alpine

ARG USER_ID
ARG GROUP_ID

RUN apk add --no-cache \
    shadow \
    icu-dev \
    libpng-dev \
    libzip-dev \
    oniguruma-dev \
    postgresql-dev \
    zip \
    unzip \
    bash

RUN docker-php-ext-install \
    pdo_pgsql \
    mbstring \
    intl \
    zip \
    pcntl \
    bcmath \
    gd

COPY . /var/www/

WORKDIR /var/www/

RUN chown -R www-data:www-data /var/www/

# Install
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --optimize-autoloader --no-interaction --no-progress --prefer-dist

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

RUN if [ ${USER_ID:-0} -ne 0 ] && [ ${GROUP_ID:-0} -ne 0 ]; then \
    userdel -f www-data &&\
    if getent group www-data ; then groupdel www-data; fi &&\
    groupadd -g ${GROUP_ID} www-data &&\
    useradd -l -u ${USER_ID} -g www-data www-data &&\
    install -d -m 0755 -o www-data -g www-data /var/www; \
    fi

EXPOSE 9000

CMD ["php-fpm"]
