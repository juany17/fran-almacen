FROM php:8.1-apache

# Instala dependencias necesarias para Node, Composer y extensiones de PHP
RUN apt-get update && apt-get install -y \
    curl gnupg unzip git libwebp-dev gifsicle optipng libpng-dev libjpeg-dev libfreetype6-dev \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia el proyecto
COPY . /var/www/html/

# Cambia al directorio del proyecto
WORKDIR /var/www/html/

# Instala extensiones de PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install mysqli gd

# Instala dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# Instala dependencias de Node.js
RUN npm install

# Corre la tarea de build para producción (cambia esto si usás otro comando)
RUN npm run build

# Expone el puerto web
EXPOSE 80
