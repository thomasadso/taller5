# Usamos una imagen base estable
FROM php:8.2-apache

# Instalamos las dependencias del sistema necesarias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libssl-dev \
    pkg-config \
    git \
    zip \
    unzip

# Instalamos las extensiones de PHP requeridas
RUN docker-php-ext-install pdo pdo_pgsql

# Instalamos la extensión de MongoDB usando PECL, pero asegurando una versión compatible
RUN pecl install mongodb-1.17.0 && docker-php-ext-enable mongodb

# Instalamos Composer de forma estándar
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configuramos el directorio de trabajo
WORKDIR /var/www/html
COPY . .

# Instalamos las dependencias del proyecto definidas en composer.json
# Esto usará la versión de la librería especificada en tu archivo
RUN composer install --no-interaction --optimize-autoloader

# Ajustamos permisos para Apache
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80