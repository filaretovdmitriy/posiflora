# Запуск бэка из консоли

docker compose exec app sh

## Переходим в каталог бэка и запускаем сам laravel
cd backend/
php artisan serve --host=0.0.0.0 --port=8000

## Запуск фронта

docker compose up frontend

# Генерация данных для теста

php artisan migrate:refresh --seed

# Запуск тестов

php artisan test

# Допущения в тестовом

Миграции в одном файле
Упрощенный fsd

