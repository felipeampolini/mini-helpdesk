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

## 1) Como rodar o projeto do zero

### 1. Clonar o repositório

```bash
git clone https://github.com/felipeampolini/mini-helpdesk.git
cd mini-helpdesk
```

### 2. Subir os containers

```bash
docker compose up -d
```

### 3. Instalar dependências

```bash
docker compose exec app composer install --no-interaction --optimize-autoloader
docker compose exec app npm install
docker compose exec app npm run build
docker compose exec app php artisan livewire:publish --assets
```

### 4. Criar arquivo `.env`

```bash
docker compose exec app cp .env.example .env
```
> Esse é o arquivo `.env` do laravel dentro da pasta `backend`

### 5. Gerar a chave da aplicação

```bash
docker compose exec app php artisan key:generate
```

### 6. Rodar migrations e seeders

```bash
docker compose exec app php artisan migrate --seed
```

### 7. Ajustar permissões

```bash
docker compose exec app chown -R www-data:www-data storage bootstrap/cache
docker compose exec app chmod -R 775 storage
```

### 8. Acesso à aplicação

Após subir o ambiente, acesse no navegador:

```
http://localhost:8000
```

### 9. Credenciais para teste

Usuário `Manager` criado via seeder:

- Email: `manager@email.com`
- Senha: `123123123`

---

## Configuração de Email (Opcional)

>Caso não configure será registrado os emails no log do laravel

O projeto utiliza o sistema de emails do Laravel.

Para ambiente de desenvolvimento, recomenda-se o uso do **Mailtrap** ou serviço similar.

Exemplo de configuração no `.env`:

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

---

## 2) Decisões técnicas relevantes

As decisões técnicas deste projeto focam em organização do código, clareza das responsabilidades e boa experiência do usuário, considerando o contexto do desafio proposto.

### Arquitetura e organização do backend

- **MVC (Model–View–Controller)**
    - Utilizado como base estrutural do projeto, seguindo o padrão nativo do Laravel.
    - Controllers mantidos com responsabilidades reduzidas, atuando principalmente como camada de orquestração.

- **Form Requests**
    - Utilizados para centralizar regras de validação.
    - Evitam duplicação de lógica e contribuem para controllers mais legíveis.

- **Policies**
    - Implementadas para controle de autorização das ações.
    - Garantem que regras de acesso por role (`user` e `manager`) sejam aplicadas de forma consistente.

- **Actions / Services**
    - Criadas para encapsular regras de negócio específicas.
    - Facilitam manutenção, leitura do código e possíveis evoluções futuras.    

### Interface e experiência do usuário

- **Livewire**
    - Escolhido para construir interfaces reativas.
    - Permite atualização de dados e interações sem reload ou redirect de página, mantendo o frontend integrado ao backend.

- **Blade**
    - Utilizado como template engine padrão.
    - Boa integração com Livewire e reutilização de componentes.

- **Localization**
    - Utilizado o sistema de Localization (i18n) do Laravel para internacionalização, com uso de chaves de tradução via funções permitindo centralizar textos, facilitar manutenção e futura expansão para múltiplos idiomas.

- **Geração de logs/notifications**
    - Criado eventos para fazer o disparo de logs, auditorias e/ou notifications em ações como criação e atualização de tickets.

- **Notificações visuais (Toasts)**
    - Utilizado o pacote `masmerise/livewire-toast` para fornecer feedback imediato ao usuário após ações como criação, atualização, erro ou informações.

- **Visualização de dados**
    - Utilizado `Chart.js` para exibição de métricas na dashboard.

### Autenticação

- **Laravel Breeze**
    - Utilizado como starter kit de autenticação.
    - Fornece fluxos prontos de login, registro, recuperação de senha e verificação de email, seguindo padrões oficiais do Laravel e baseada em session e cookies.

### Ambiente

- **Docker e Docker Compose**
    - Utilizados para padronizar o ambiente de desenvolvimento.
    - Facilitam a execução do projeto e a avaliação por terceiros.

---

## 3) Testes

O projeto conta com testes automatizados utilizando PHPUnit, focados principalmente nos fluxos críticos de autenticação, perfil de usuário e tickets que podem ser rodados usando:

```bash
docker compose exec app php artisan test
```

---

## 4) Funcionalidades implementadas e pendências

### Implementadas
- Autenticação:
    - Login;
    - Registro;
    - Recuperar senha;
    - Logout;
    - Deletar conta;
    - Atualizar perfil;

- Dashboard com gráficos:
    - Numero de tickets abertos/em andamento/fechados com contagem de prioridade;
    - Gráfico com tickets abertos por `dia` e por `mes`;
    - Gráfico com total de tickets abertos/fechados por `dia` e por `mes`;

- Gestão de tickets:
    - Criar;
    - Visualizar;
    - Editar;
    - Troca de status `open`->`in_progress`->`closed`->`open`;

- Listagem de tickets:
    - Ordenados por padrão do mais recente pro mais antigo;
    - Páginação;
    - Filtros por Texto (Título, descrição, nome, ID), status, prioridade, criado de e criado até;
    - Ordenação por todas colunas, id, título, status, prioridade, dono e criado em;

- Comentários:
    - Criar comentários;
    - Listar comentários em ordem cronológica;

- Controle de permissões
    - Seguido regras para os diferentes roles `user` e `manager`.

### Pendências
- Nenhuma

### Possíveis melhorias
- Criação de tabela de eventos de tickets para histórico de abertura, fechamento e reabertura que pode ser usada para gráficos na dashboard;
- Criação de tabelas para uso de RBAC (Role-Based Access Control), para permitir outros tipos de roles e autorizações mais complexas;
- Criação de um view estilo To Do list, com colunas para cada status;
- Integração com APIs para facilitar login (google, instagram, etc);
- Utilizar 2FA para login, aumentando a segurança das contas;
- Utilizar reCAPTCHA para evitar brute force e spam de criação de contas;

### Bugs conhecidos
- Filtros são perdidos ao voltar de um ticket para a listagem;
- Testes test_user_cannot_see_tickets_from_other_users() e test_user_sees_only_own_tickets() retornam success ou error de formas aleatorias, provavel culpa do componente livewire.

---

## 5) Recursos usados no desenvolvimento

### Inteligência Artificial

**ChatGPT**
- Validação de ideias
- Sugestão de bibliotecas
- Geração e revisão de código
- Traduções e componentes
- Configuração do Docker
- Formatação do README

**Google Gemini**
- Identificação de bugs no Livewire
- Auxílio com notificações toast

### Bibliotecas
- Laravel Breeze
- Livewire
- masmerise/livewire-toast
- Chart.js
- PHPUnit

### Recursos próprios
- Snippets pessoais para padronização do uso da função `__()`.

---

## Licença

Este projeto está sob a licença MIT.
