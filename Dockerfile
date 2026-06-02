FROM php:8.2-apache

# Instalar dependencias del sistema para Postgres y Mongo
RUN apt-get update && apt-get install -y libpq-dev libssl-dev pkg-config git zip unzip

# Instalar extensiones de PHP: PDO PostgreSQL y MongoDB
RUN docker-php-ext-install pdo pdo_pgsql
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar archivos y dar permisos
COPY . /var/www/html/
WORKDIR /var/www/html/

# Ejecutar Composer
RUN composer install --ignore-platform-reqs

# Exponer el puerto de Apache
EXPOSE 80