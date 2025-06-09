FROM php:8.1-apache

# Instala Node.js, npm y dependencias necesarias para gulp-imagemin y webp
RUN apt-get update && \
    apt-get install -y curl gnupg libwebp-dev gifsicle optipng && \
    curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Copia el proyecto
COPY . /var/www/html/

# Instala extensiones de PHP
RUN docker-php-ext-install mysqli

# Cambia al directorio del proyecto
WORKDIR /var/www/html/

# Instala dependencias de Node.js
RUN npm install

# Corre la tarea de Gulp
RUN npm run dev

EXPOSE 80
