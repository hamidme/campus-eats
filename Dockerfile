# Use PHP 8.2 with Apache
FROM php:8.2-apache

# 1. Install Zip, Intl, and other tools
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git libicu-dev \
    && docker-php-ext-install pdo_mysql zip intl bcmath \
    && a2enmod rewrite

# 2. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3. Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# 4. Copy app files
WORKDIR /var/www/html
COPY . .

# --- CRITICAL FIX: Remove the local lock file ---
RUN rm -f composer.lock
# ------------------------------------------------

# 5. Install dependencies (Ignore version errors)
RUN composer install --ignore-platform-reqs --no-interaction --optimize-autoloader

# 6. Build frontend
RUN npm install && npm run build

# 7. Permissions & Config
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf
RUN sed -i 's/80/${PORT}/g' /etc/apache2/ports.conf /etc/apache2/sites-enabled/000-default.conf

# 8. Start
CMD ["apache2-foreground"]