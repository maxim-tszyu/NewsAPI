# NewsAPI

REST API для новостного каталога, реализованный на Laravel.
Проект позволяет управлять новостями, авторами и рубриками, а также предоставляет аутентификацию через token-based систему (Laravel Sanctum).

Документация Swagger доступна по адресу:
[http://localhost:8000/api/documentation#/](http://localhost:8000/api/documentation#/)

---

## Требования

* PHP >= 8.2
* Composer
* MySQL
* Laravel 12
---

## Установка

1. **Клонировать репозиторий**

```bash
git clone https://github.com/maxim-tszyu/NewsAPI.git
cd NewsAPI
```

2. **Установить зависимости через Composer**

```bash
composer install
```

3. **Скопировать файл окружения**

```bash
cp .env.example .env
```

4. **Сгенерировать ключ приложения**

```bash
php artisan key:generate
```

5. **Настроить базу данных**
   В `.env` укажите ваши данные:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=newsapi
DB_USERNAME=root
DB_PASSWORD=secret
```

6. **Выполнить миграции**

```bash
php artisan migrate --seed
```

7. **(Опционально) Создать storage link для публичного доступа к аватарам**

```bash
php artisan storage:link
```

8. **Сгенерировать Swagger документацию**

```bash
php artisan l5-swagger:generate
```

9. **Запуск локального сервера**

```bash
php artisan serve
# API будет доступно по адресу:
http://127.0.0.1:8000
```

---

## Регистрация и аутентификация

Перед использованием API необходимо зарегистрироваться через endpoint:

```http
POST /api/v1/register
```

После успешной регистрации вы получите token, который нужно использовать для доступа к защищённым эндпоинтам.

Для выхода из системы используется endpoint:

```http
POST /api/v1/logout
```

---

## Документация API

Swagger документация доступна после генерации:

[http://localhost:8000/api/documentation#/](http://localhost:8000/api/documentation#/)

Документация содержит все эндпоинты, схемы запросов (`StoreNewsRequest`, `StoreAuthorRequest` и т.д.) и примеры ответов.

---

## Основные возможности

* CRUD для новостей
* CRUD для авторов
* CRUD для рубрик
* Получение новостей конкретного автора
* Получение новостей по рубрике, включая дочерние
* Поиск новостей по заголовку
* Token-based аутентификация
* Swagger документация для всех API эндпоинтов

---

## Дополнительно

* Очереди для отправки email авторам при добавлении новости
* Валидация через FormRequest
* Accessors & Mutators для работы с аватарами
* Использование Middleware для защиты эндпоинтов

---

## Структура проекта (кратко)

* `app/Models` – модели новостей, авторов, рубрик
* `app/Http/Controllers` – контроллеры API
* `app/Http/Requests` – кастомные FormRequest для валидации
* `app/Services` – вспомогательные сервисы (например, RubricHelperService)
* `routes/api.php` – маршруты API
* `database/migrations` – миграции базы данных
