# ใช้ image ของ PHP 8.1
FROM php:8.1-fpm

# ติดตั้ง dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# ตั้งค่า working directory
WORKDIR /var/www

# คัดลอก composer และติดตั้ง dependencies
COPY composer.json composer.lock ./
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# คัดลอกไฟล์ทั้งหมด
COPY . .

# สั่งให้ run Laravel เมื่อ container start
CMD ["php-fpm"]
