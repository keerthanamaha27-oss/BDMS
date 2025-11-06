FROM php:8.2-apache

# Install system packages and PHP extensions
RUN apt-get update \
     && apt-get install -y --no-install-recommends \
         libzip-dev zip unzip git default-mysql-client libpng-dev libjpeg-dev libfreetype6-dev \
     && docker-php-ext-configure gd --with-freetype --with-jpeg \
     && docker-php-ext-install pdo_mysql mysqli gd zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy application code into the web root
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Copy entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Expose the default HTTP port (entrypoint updates Apache to the $PORT provided by Render)
EXPOSE 80

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["apache2-foreground"]
