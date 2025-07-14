# project-rabbitmq-mongodb
Projeto para estudar Laravel 12, MongoDB e RabbitMQ e Docker

## Configurar o ambiente:
1. Criar os containers
```bash
   docker compose up -d --build
```

2. Rodar as migrations de log-api
```bash
   docker compose exec stock-api php artisan migrate
```
