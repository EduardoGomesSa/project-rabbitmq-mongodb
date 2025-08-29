FROM laravelsail/php83-composer

WORKDIR /var/www/html

COPY . .

# Instala dependências de sistema e extensões PHP
RUN apt-get update \
  && apt-get install -y libpq-dev libzip-dev zip unzip git curl \
  && docker-php-ext-install pdo pdo_mysql zip sockets \
  && rm -rf /var/lib/apt/lists/*

# Instala dependências do projeto
RUN composer install

# Comando padrão para rodar o servidor Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
