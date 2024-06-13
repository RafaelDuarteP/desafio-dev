FROM php:8.1.17

WORKDIR /api

COPY ./ /api/

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    && docker-php-ext-install -j$(nproc) gd iconv mbstring exif pcntl mysqli pdo pdo_mysql zip\
    && docker-php-ext-configure gd --with-freetype --with-jpeg

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "-t", "public/"]