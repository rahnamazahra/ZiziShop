FROM php:8.2-fpm

# نصب ابزارها و اکستنشن‌های PHP موردنیاز
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libcurl4-openssl-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl gd

# نصب Composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# تنظیم دایرکتوری کاری
WORKDIR /var/www

# کپی کردن فایل‌های پروژه (در زمان build)
COPY . .

# نصب پکیج‌های لاراول
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# تنظیم پرمیشن‌ها (در صورت نیاز)
#RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

CMD ["php-fpm"]
