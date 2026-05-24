FROM php:8.3-apache

# Install system deps
RUN apt-get update && apt-get install -y \
    git unzip curl zip libicu-dev libzip-dev gnupg

# Install PHP extensions
RUN docker-php-ext-install intl pdo pdo_mysql zip

# Install Node.js (IMPORTANT)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

RUN a2enmod rewrite

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

# PHP deps
RUN composer install --no-dev --no-scripts --optimize-autoloader

# JS deps + build (IMPORTANT FIX)
RUN npm install
RUN npm run build

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf

RUN chown -R www-data:www-data var public/build

EXPOSE 80