# Сборка и запуск контейнеров
build:
	docker-compose build --no-cache
	docker-compose up -d

# Запуск контейнеров
up:
	docker-compose up -d

# Установка проекта
install:
	cp .env.example .env
	cp .env.testing.example .env.testing
	make build
	docker-compose exec app composer install
	npm install
	npm run dev
	docker-compose exec app php artisan key:generate
	docker-compose exec app php artisan migrate
	docker-compose exec app php artisan db:seed

# Запуск миграций
migrate:
	docker-compose exec app php artisan migrate

bash:
	docker-compose exec app bash