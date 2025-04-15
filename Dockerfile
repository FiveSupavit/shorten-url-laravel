FROM php:8.2-fpm

# 1. ติดตั้ง dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    nano \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl bcmath gd

# 2. ติดตั้ง Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3. ตั้ง working directory
WORKDIR /var/www

# 4. Copy โค้ดทั้งหมด
COPY . .

# 5. ติดตั้ง package Laravel
RUN composer install --optimize-autoloader --no-dev

# 6. กำหนด permission
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

# 7. เปิด port
EXPOSE 8000

# 8. คำสั่งรัน Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000
