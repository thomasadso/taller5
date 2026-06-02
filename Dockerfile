# Usamos una imagen de PHP con Apache
FROM php:8.2-apache

# Instalamos las dependencias del sistema necesarias para PostgreSQL y Mongo
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libssl-dev \
    pkg-config \
    git \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb

# Instalamos Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configuramos el directorio de trabajo
WORKDIR /var/www/html
COPY . .

# Instalamos dependencias
RUN composer install --no-interaction

EXPOSE 80