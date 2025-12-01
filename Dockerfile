FROM php:8.2-apache

# Enable mod_rewrite
RUN a2enmod rewrite

# Install PHP extensions you need
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Allow .htaccess overrides
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf
