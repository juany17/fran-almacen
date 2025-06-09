# Usa una imagen oficial de PHP con Apache
FROM php:8.1-apache

# Instala dependencias para Node y para PHP mysqli
RUN apt-get update && apt-get install -y \
    curl \
    unzip \
    git \
    npm \
    && docker-php-ext-install mysqli

# Copia los archivos del proyecto al directorio raíz de Apache
COPY . /var/www/html/

# Establece el directorio de trabajo
WORKDIR /var/www/html/

# Instala Node.js y dependencias npm
RUN npm install

# Ejecuta gulp para compilar assets
RUN npx gulp build

# Da permisos a los archivos
RUN chown -R www-data:www-data /var/www/html

# Expone el puerto 80
EXPOSE 80
