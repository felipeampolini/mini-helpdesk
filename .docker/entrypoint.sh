#!/bin/bash

# Entra na pasta do backend
cd /var/www/html/backend

# Cria o .env se não existir
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Instala/Finaliza o composer e gera a chave
composer install --no-interaction --optimize-autoloader
php artisan key:generate --force

# Aguarda o Banco de Dados (opcional, mas recomendado)
echo "Aguardando migrações..."
php artisan migrate --seed --force

# Build de assets
npm run build
php artisan livewire:publish --assets

# Ajusta permissões finais
chown -R www-data:www-data storage bootstrap/cache

# Inicia os serviços
php-fpm -D
nginx -g 'daemon off;'