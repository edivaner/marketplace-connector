# 1. Base PHP 8.3
FROM php:8.3-cli

# 2. Dependências de SO e extensões PHP
RUN apt-get update && apt-get install -y \
    git zip unzip libpng-dev libonig-dev libxml2-dev \
  && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
  && pecl install redis \
  && docker-php-ext-enable redis \
  && rm -rf /var/lib/apt/lists/*

# 3. Composer (da imagem oficial)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 4. Define diretório de trabalho e copia tudo
WORKDIR /var/www/html
COPY . .

# 5. Instala dependências PHP
#    --no-interaction evita prompts, 
#    --optimize-autoloader acelera o autoload em produção
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 6. Ajusta permissões para storage e cache
RUN chown -R www-data:www-data storage bootstrap/cache

# 7. Expõe porta 8000 para o servidor Laravel
EXPOSE 8000

# 8. Comando padrão: inicia o servidor embutido do Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=3001"]
