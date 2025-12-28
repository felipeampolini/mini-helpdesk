# Mini Helpdesk

![Laravel](https://img.shields.io/badge/Laravel-11-red)
![PHP](https://img.shields.io/badge/PHP-8.2-blue)
![Docker](https://img.shields.io/badge/Docker-Compose-blue)
![License](https://img.shields.io/badge/license-MIT-green)

Projeto **Mini Helpdesk** desenvolvido com Laravel, utilizando Docker para padronizar o ambiente de desenvolvimento e facilitar a execução do projeto.

---

## Tecnologias Utilizadas

### Backend
- PHP 8.2
- Laravel 11
- Laravel Breeze (autenticação)
- PostgreSQL
- PHPUnit (testes)

### Frontend
- Blade (views)
- Tailwind CSS (estilização)
- Livewire (componentes reativos)
- Vite
- Node.js
- NPM

### Infraestrutura
- Docker
- Docker Compose
- Nginx

---

## Requisitos

Antes de começar, você precisa ter instalado na sua máquina:

- Docker
- Docker Compose
- Git

---

## Como rodar o projeto

### 1. Clonar o repositório

```bash
git clone https://github.com/felipeampolini/mini-helpdesk.git
cd mini-helpdesk
```

---

### 2. Subir os containers

```bash
docker compose up -d
```

### 3. Instalar dependencias

```bash
docker compose exec app composer install --no-interaction --optimize-autoloader
docker compose exec app npm install
docker compose exec app npm run build
docker compose exec app php artisan livewire:publish --assets
```

---

### 4. Criar .env do laravel

```bash
docker compose exec app cp .env.example .env
```

---

### 5. Gerar a chave da aplicação

```bash
docker compose exec app php artisan key:generate
```

---

### 6. Rodar as migrations junto com os seeders

```bash
docker compose exec app php artisan migrate --seed
```

### 7. Concede permissoes

```bash
docker compose exec app chown -R www-data:www-data storage bootstrap/cache
docker compose exec app chmod -R 775 storage
```

---

## Acesso à aplicação

Após subir o ambiente, acesse no navegador:

```
http://localhost:8000
```

---

## Autenticação

O projeto utiliza **Laravel Breeze** para autenticação:

- Registro de usuário
- Login
- Logout
- Gerenciamento de sessões via banco de dados

## Login de usuario Manager

Email: `manager@email.com`

Senha: `123123123`

---

## Envio de Emails (Ambiente de Desenvolvimento)

Este projeto utiliza o sistema de emails do Laravel para funcionalidades como recuperação de senha, verificação de email entre outras.

Em ambiente de desenvolvimento, é recomendado o uso do **Mailtrap**, que permite capturar emails enviados pela aplicação sem entregá-los a endereços reais.

### Exemplo de configuração

No arquivo `.env`, utilize uma configuração semelhante a esta:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

As credenciais podem ser obtidas gratuitamente em https://mailtrap.io

---

## Licença

Este projeto está sob a licença MIT.
