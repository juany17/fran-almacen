# Usa PHP + Apache como base
FROM php:8.1-apache

# Instala Node.js y npm
RUN apt-get update && apt-get install -y curl gnupg \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Instala extensiones necesarias de PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql && a2enmod rewrite

# Copia los archivos de npm y corre npm install
COPY package*.json ./
RUN npm install

# Copia el resto del proyecto
COPY . /var/www/html/

# Ejecuta tu build con gulp
RUN npm run dev

# Ajusta permisos
RUN chown -R www-data:www-data /var/www/html

# Expone el puerto
EXPOSE 80
