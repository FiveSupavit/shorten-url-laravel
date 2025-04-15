# ใช้ image ของ PHP กับ Apache
FROM php:8.1-apache

# ติดตั้ง Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# ติดตั้ง PHP extensions ที่จำเป็นสำหรับ Laravel
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# ตั้งค่า Apache document root ให้ชี้ไปที่ public ของ Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Copy โค้ดจากเครื่องของคุณไปใน container
COPY . /var/www/html/

# ตั้งสิทธิ์ให้กับโฟลเดอร์ที่จำเป็น
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# สั่งให้ Apache ทำงาน
CMD ["apache2-foreground"]
