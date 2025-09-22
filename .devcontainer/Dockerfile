FROM php:8.2-apache

# Install GD and other PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Enable Apache mod_rewrite (optional for routing)
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html
