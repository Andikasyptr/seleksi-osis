FROM php:8.2-apache

# Install dependencies sistem
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    libonig-dev \
    libxml2-dev

# Install ekstensi PHP yang dibutuhkan Laravel & Composer
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo_mysql gd zip bcmath mbstring exif pcntl bcmath xml

# Aktifkan Apache mod_rewrite
RUN a2enmod rewrite

# Salin custom vhost Apache
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Salin Composer dari image resmi
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Tentukan working directory
WORKDIR /var/www/html

# Salin file composer terlebih dahulu
COPY composer.json composer.lock ./

# Install vendor dependencies dengan menaikkan limit memori PHP (-d memory_limit=-1)
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --optimize-autoloader --no-scripts -d /var/www/html

# Salin seluruh sisa file project ke dalam container
COPY . /var/www/html

# Jalankan script post-autoload
RUN COMPOSER_ALLOW_SUPERUSER=1 composer run-script post-autoload-dump || true

# Beri hak akses (permission) penuh ke folder storage dan bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80