FROM php:8.1-apache

# Instala dependencias necesarias para Node, gulp-imagemin y webp
RUN apt-get update && apt-get install -y \
    curl gnupg libwebp-dev gifsicle optipng libpng-dev libjpeg-dev libfreetype6-dev \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean

# Copia el proyecto
COPY . /var/www/html/

# Cambia al directorio del proyecto
WORKDIR /var/www/html/

# Instala extensiones de PHP (mysqli)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install mysqli gd

# Instala dependencias de Node.js
RUN npm install

# Corre la tarea de build para producción (no uses 'dev' que es para desarrollo y con watch)
RUN npm run build

# Expone el puerto 80
EXPOSE 80
