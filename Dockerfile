FROM php:8.2-fpm

# Instala dependências do sistema e o utilitário dos2unix
RUN apt-get update && apt-get install -y \
    git unzip curl libpq-dev libonig-dev libzip-dev zip nginx dos2unix \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instala Node.js e Composer
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && apt-get install -y nodejs
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html/backend

# Copia arquivos de dependências primeiro (Cache Layer)
COPY backend/package*.json backend/composer.* ./

# Instala dependências (sem rodar scripts do Laravel ainda)
RUN composer install --no-interaction --no-scripts --no-autoloader \
    && npm install

# Copia o restante do código
COPY backend/ ./

# Configuração do Nginx
RUN rm -f /etc/nginx/sites-enabled/default
COPY .docker/nginx/laravel.conf /etc/nginx/sites-enabled/laravel.conf

# Ajuste de permissões inicial
RUN chown -R www-data:www-data /var/www/html/backend \
    && chmod -R 775 /var/www/html/backend/storage /var/www/html/backend/bootstrap/cache

# Copia o script que vai automatizar tudo ao subir
COPY .docker/entrypoint.sh /usr/local/bin/entrypoint.sh

# Corrige quebras de linha do Windows e dá permissão de execução
RUN dos2unix /usr/local/bin/entrypoint.sh && chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80

ENTRYPOINT ["entrypoint.sh"]