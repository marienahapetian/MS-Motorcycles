FROM php:8.3-apache

# System dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    gnupg \
    libicu-dev \
    libzip-dev \
    libonig-dev \
    libpq-dev \
    libxml2-dev

# PHP extensions
RUN docker-php-ext-install \
    intl \
    pdo \
    pdo_mysql \
    mbstring \
    zip \
    opcache

# Install Node.js (IMPORTANT - must come BEFORE npm commands)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

RUN a2enmod rewrite

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy ONLY dependency files first (better caching)
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --prefer-dist --optimize-autoloader

# Copy everything else (INCLUDING package.json)
COPY . .

# Install JS dependencies + build assets
RUN npm install
RUN npm run build

# Apache config for Symfony
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf

# Permissions
RUN mkdir -p var/cache var/log public/build \
    && chown -R www-data:www-data var public/build

EXPOSE 80