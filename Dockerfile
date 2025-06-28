FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git unzip zip libicu-dev libonig-dev libpq-dev libzip-dev libxml2-dev \
    && docker-php-ext-install intl opcache pdo pdo_pgsql pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /var/www/html

RUN a2enmod rewrite

WORKDIR /var/www/html

RUN composer install --no-interaction --optimize-autoloader

EXPOSE 80
