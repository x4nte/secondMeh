# Стадия сборки
FROM composer:2 as builder
FROM php:8.4-fpm-alpine
COPY --from=builder /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/app

# Установка зависимостей
RUN apk add --no-cache \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_mysql zip opcache

COPY . .
COPY /docker/php-fpm/php.ini /usr/local/etc/php/conf.d/custom.ini

# Права доступа
RUN chown -R www-data:www-data /var/www/app