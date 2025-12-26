# PHP-FPM base
FROM php:8.2-fpm

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    git unzip curl libpq-dev libonig-dev libzip-dev zip \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instala Node.js e NPM
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Define diretório de trabalho
WORKDIR /var/www/html/backend

# Cria pastas necessárias (storage, bootstrap/cache)
RUN mkdir -p storage bootstrap/cache

# Copia todo o backend primeiro
COPY backend/ ./

# Instala dependências PHP + Node
RUN composer install --no-interaction --optimize-autoloader --no-dev
RUN npm install
RUN npm run build

# Ajusta permissões
RUN chown -R www-data:www-data storage bootstrap/cache

# Expondo porta 80
EXPOSE 80

# Start Nginx e PHP-FPM
RUN apt-get update && apt-get install -y nginx \
    && rm /etc/nginx/sites-enabled/default \
    && echo "server { listen 80; root /var/www/html/backend/public; index index.php index.html; location / { try_files \$uri /index.php?\$query_string; } location ~ \.php\$ { fastcgi_pass 127.0.0.1:9000; fastcgi_index index.php; include fastcgi_params; fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name; } }" > /etc/nginx/sites-available/default \
    && ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# Start PHP-FPM e Nginx
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]
