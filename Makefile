# Сборка и запуск контейнеров
build:
	docker-compose build --no-cache
	docker-compose up -d

# Запуск контейнеров
up:
	docker-compose up -d

# Установка проекта
install:
	composer install
	npm install
	npm run dev
	make build
	docker-compose exec app cp .env.example .env
	docker-compose exec app php artisan key:generate
	docker-compose exec app php artisan migrate
	docker-compose exec app php artisan db:seed