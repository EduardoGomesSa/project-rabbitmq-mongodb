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
3. Verificar quais containers estão rodando:
```bash
   docker compose ps
```
4. Caso não estejam rodando, execute:
```bash
   docker compose up -d
```
5. Entrar em um container de uma api específica:
```bash
   docker compose exec stock-api bash
```
## Tecnologias utilizadas:
- Laravel 12
- RabbitMQ
- MongoDB
- EloquentORM
- Insomnia
- MVC

#
<p align="center">🚧 Projeto em construção 🚧</p>
