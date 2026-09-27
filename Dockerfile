FROM php:8.3-apache

# 1. Install dependencies sistem & tools penting
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

# 2. Install semua ekstensi PHP yang wajib untuk Laravel & MySQL
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo_mysql gd zip bcmath mbstring exif pcntl xml

# 3. Aktifkan Apache mod_rewrite untuk routing Laravel
RUN a2enmod rewrite

# 4. Salin konfigurasi Virtual Host Apache
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# 5. Ambil Composer resmi versi terbaru
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 6. Tentukan direktori kerja utama
WORKDIR /var/www/html

# 7. Salin file composer terlebih dahulu agar cache optimal
COPY composer.json composer.lock ./

# 8. Install vendor dependencies TANPA menjalankan scripts otomatis
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --optimize-autoloader --ignore-platform-reqs --no-scripts

# 9. Salin seluruh sisa file project ke dalam container (termasuk folder app, artisan, dll)
COPY . /var/www/html

# 10. Jalankan package discovery secara manual sekarang setelah file lengkap
RUN COMPOSER_ALLOW_SUPERUSER=1 php artisan package:discover --ansi || true

# 11. Set hak akses (permissions) yang aman untuk folder storage & cache Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80