FROM php:8.2-apache

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libssl-dev \
    pkg-config \
    git \
    zip \
    unzip

# Instalar extensión MongoDB compatible (1.16.0)
RUN pecl install mongodb-1.16.0 && docker-php-ext-enable mongodb

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html
COPY . .

# Instalar dependencias limpiamente
RUN composer install --no-interaction

EXPOSE 80