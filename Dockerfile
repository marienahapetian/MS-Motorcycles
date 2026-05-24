FROM php:8.3-apache

# =========================
# System dependencies
# =========================
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

# =========================
# PHP extensions
# =========================
RUN docker-php-ext-install \
    intl \
    pdo \
    pdo_mysql \
    mbstring \
    zip \
    opcache

# =========================
# Node.js (Webpack Encore)
# =========================
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# =========================
# Apache setup
# =========================
RUN a2enmod rewrite

# IMPORTANT: allow .htaccess (fix routing + static files)
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# =========================
# Composer
# =========================
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# =========================
# Install PHP dependencies first
# =========================
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --prefer-dist --optimize-autoloader

# =========================
# Copy project
# =========================
COPY . .

# =========================
# Frontend build (Encore)
# =========================
RUN npm install
RUN npm run build

# =========================
# Apache document root (CRITICAL)
# =========================
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf

# =========================
# FIX: uploads + Symfony cache + build folders
# =========================
RUN mkdir -p \
    var/cache \
    var/log \
    public/build \
    public/images/uploads

RUN chown -R www-data:www-data \
    var \
    public/build \
    public/images/uploads

# =========================
# Permissions safety
# =========================
RUN chmod -R 775 var public/images/uploads

EXPOSE 80