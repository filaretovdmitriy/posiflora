# Запуск бэка из консоли

docker compose exec app sh

## Переходим в каталог бэка и запускаем сам laravel
cd backend/
php artisan serve --host=0.0.0.0 --port=8000

## Запуск фронта

docker compose up frontend

# Генерация данных для теста, создастся магазин в т.ч. с номером 123

php artisan migrate:fresh --seed

http://localhost:5173/shops/123/growth/telegram

# Запуск тестов

php artisan test

# Допущения в тестовом

Миграции в одном файле
Тесты в одном файле
Упрощенный fsd
Изменения в ветке Dev


