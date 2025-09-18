FROM php:8.1-fpm

RUN apt-get update && apt-get install -y  \
    libfreetype6-dev \
    libjpeg-dev \
    libpng-dev \
    libwebp-dev \
    --no-install-recommends \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql -j$(nproc) gd

RUN addgroup -g 1000 -S www && \
    adduser -u 1000 -S www -G www

#USER root

COPY --chown=www:www-data . /var/www

RUN chown -R www:www-data /var/www/storage
RUN chmod -R ug+w /var/www/storage

EXPOSE 9000
