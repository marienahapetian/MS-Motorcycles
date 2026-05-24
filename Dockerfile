FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libicu-dev \
    libzip-dev \
    libonig-dev \
    libpq-dev \
    libxml2-dev \
    && docker-php-ext-install \
    intl \
    pdo \
    pdo_mysql \
    mbstring \
    zip \
    opcache

RUN a2enmod rewrite

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./

RUN composer install --no-dev --no-scripts --prefer-dist --optimize-autoloader

COPY . .

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf

RUN mkdir -p var/cache var/log
RUN chown -R www-data:www-data var

EXPOSE 80