FROM laravelsail/php83-composer

WORKDIR /var/www/html

COPY . .

RUN apt-get update \
  && apt-get install -y libpq-dev libzip-dev zip unzip git curl pkg-config libssl-dev \
  && pecl install mongodb \
  && docker-php-ext-enable mongodb \
  && docker-php-ext-install pdo pdo_mysql zip

RUN composer install

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
