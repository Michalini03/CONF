# Start from the official php:apache image
FROM php:apache

# Install the pdo_mysql and mysqli extensions
RUN docker-php-ext-install pdo_mysql mysqli

# --- ADD THESE TWO LINES ---

# 1. Enable Apache's rewrite module
RUN a2enmod rewrite

# 2. Tell Apache to read .htaccess files by changing "AllowOverride None" to "AllowOverride All"
RUN sed -i '/<Directory \/var\/www\/html>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf