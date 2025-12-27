## Comandos auxiliares para desenvolvimento

Acessar o bash do container

```bash
docker compose exec app bash
```

---

Limpa cache de configuração (config/app.php, .env, etc.)

```bash
php artisan config:clear
```

Limpa cache de rotas

```bash
php artisan route:clear
```

Limpa cache de views compiladas

```bash
php artisan view:clear
```

Limpa cache de eventos e listeners (não existe comando direto, mas reiniciar o cache ajuda)

```bash
php artisan event:clear
```
