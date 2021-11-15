FROM php:8.0.0-apache

RUN apt update -y && apt install -y --no-install-recommends \
      libzip-dev \
    && pecl install redis \
    && docker-php-ext-install zip \
    && docker-php-ext-enable redis \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY index.php /var/www/html/
