# PHP-FPM base
FROM php:8.2-fpm

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    git unzip curl libpq-dev libonig-dev libzip-dev zip nginx \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instala Node.js e NPM
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Define diretório de trabalho
WORKDIR /var/www/html/backend

#  Copia primeiro os arquivos de definição
COPY backend/composer.json backend/composer.lock* ./
COPY backend/package*.json ./

# Instala dependências iniciais (Camada de cache)
RUN composer install --no-interaction --no-scripts --no-autoloader
RUN npm install

# Copia o resto do código
COPY backend/ ./

# Remove qualquer resquício de pastas do Windows que possam ter vindo no COPY
# Isso garante que o Vite use apenas o que o NPM do Linux instalou.
RUN rm -rf node_modules vendor && \
    composer install --no-interaction --optimize-autoloader && \
    npm install
# ----------------------

# Build do Vite
# RUN npm run build

# --- CONFIGURAÇÕES DE AMBIENTE ---

# Cria pastas e ajusta permissões
RUN mkdir -p storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Configuração do Nginx
RUN rm -f /etc/nginx/sites-enabled/default \
    && echo "server { \
    listen 80; \
    root /var/www/html/backend/public; \
    index index.php index.html; \
    location / { \
        try_files \$uri \$uri/ /index.php?\$query_string; \
    } \
    location ~ \.php\$ { \
    fastcgi_pass 127.0.0.1:9000; \
    fastcgi_index index.php; \
    include fastcgi_params; \
    fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name; \
    } \
}" > /etc/nginx/sites-available/laravel.conf \
    && ln -s /etc/nginx/sites-available/laravel.conf /etc/nginx/sites-enabled/

EXPOSE 80

CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]