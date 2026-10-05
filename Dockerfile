FROM composer:2 AS vendor 
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist 
COPY . .
RUN composer install --dump-autoloader --optimize --no-dev

FROM node:20 AS assest 
WORKDIR /app
COPY package*.json ./   
RUN npm ci 
COPY . . 
RUN npm run build 

FROM php:8.3-apache 
RUN apt-get update && apt-get install -y \ 
libzip-dev libpq-dev unzip \
&& docker-php-ext-install pdo pdo_mysql pdo_pgsql zip opcache \
&& a2enmod rewrite \
&& rm -rf /var/lib/apt/list/*

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/ver/www/html!${APACHE_DOCUMENT_DOOT}!g' \
\etc\apache2\sites-avaiable/*.conf \
\etc/apache2/apache2.conf \
\etc/apache2/conf-available/*.conf

WORKDIR /var/wwww/html
COPY --from=vendor /app /var/www/html
COPY --from=assets /app/public/build /var/www/html/public/build

RUN chown -R www-data:www-data storage bootstrap/cache

COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 80
CMD ["/start.sh"]
