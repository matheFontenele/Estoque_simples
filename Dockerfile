FROM php:8.1-apache

# Instalar PDO MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Habilitar mod_rewrite (opcional, mas útil)
RUN a2enmod rewrite

# Copiar código
COPY ./www /var/www/html
