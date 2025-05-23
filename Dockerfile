# Usa una imagen oficial de PHP con Apache
FROM php:8.1-apache

# Copia los archivos del proyecto al directorio raíz de Apache
COPY . /var/www/html/

# Da permisos a los archivos
RUN chown -R www-data:www-data /var/www/html

# Habilita módulos necesarios si los usas (opcional)
RUN docker-php-ext-install mysqli

# Expone el puerto 80
EXPOSE 80
