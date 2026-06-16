# Usa la imagen oficial de PHP con Apache
FROM php:8.2-apache

# Habilitar el módulo de reescritura de Apache
RUN a2enmod rewrite

# Configurar Apache para que busque primero 'validacion.html' como página de inicio
RUN echo "DirectoryIndex validacion.html index.php index.html" >> /etc/apache2/apache2.conf

# Copiar todos tus archivos al servidor
COPY . /var/www/html/

# Dar los permisos correctos
RUN chown -R www-data:www-data /var/www/html/

# Exponer el puerto estándar
EXPOSE 80
