# Usa una imagen oficial de PHP con Apache
FROM php:7.4-apache

# Configura las extensiones necesarias para Laravel
RUN docker-php-ext-install pdo pdo_mysql

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configura el directorio de trabajo
WORKDIR /var/www/html

# Copia el contenido del proyecto al contenedor
COPY . .

# Establece permisos
RUN chown -R www-data:www-data /var/www/html

# Exposición del puerto 80
EXPOSE 80
