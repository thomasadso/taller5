# Usamos una imagen de PHP que es más fácil de configurar para estas extensiones
FROM php:8.2-apache

# Instalamos las dependencias necesarias de una sola vez
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libssl-dev \
    pkg-config \
    git \
    zip \
    unzip \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install pdo pdo_pgsql

# Instalamos Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configuramos el directorio
WORKDIR /var/www/html
COPY . .

# Instalamos dependencias sin interactividad
RUN composer install --no-interaction

# Aseguramos permisos
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80