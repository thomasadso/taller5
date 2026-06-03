FROM php:8.2-apache

# Instalamos las dependencias necesarias y fijamos la versión exacta de MongoDB a la 1.18.1
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libssl-dev \
    pkg-config \
    git \
    zip \
    unzip \
    && pecl install mongodb-1.18.1 \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install pdo pdo_pgsql

# Instalamos Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configuramos el directorio de trabajo
WORKDIR /var/www/html
COPY . .

# Instalamos dependencias limpiamente
RUN composer install --no-interaction

# Aseguramos permisos
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80