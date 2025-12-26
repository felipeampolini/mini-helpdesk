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
- Blade
- Tailwind CSS
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

### 6. Rodar as migrations

```bash
docker compose exec app php artisan migrate
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

---

## Licença

Este projeto está sob a licença MIT.
