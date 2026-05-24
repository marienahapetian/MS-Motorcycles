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

# Enable Apache rewrite (IMPORTANT for Symfony routes)
RUN a2enmod rewrite

# CRITICAL FIX: allow .htaccess overrides
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Set correct document root (VERY IMPORTANT)
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy dependency files first (better caching)
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --prefer-dist --optimize-autoloader

# Copy full project
COPY . .

# Ensure required folders exist (IMPORTANT for uploads + cache)
RUN mkdir -p var/cache var/log public/images/uploads \
    && chown -R www-data:www-data var public/images/uploads

EXPOSE 80