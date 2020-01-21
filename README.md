# dcosts

Сервис предназначен для учета повседневных затрат и доходов с разбиением по статьям и послудующей аналитикой. 

## Установка

    composer install
    cp .env.example .env
    npm install
    npm run dev

* Запуск docker-контейнеров:
  
        docker-compose up -d --build    
    
* Установка прав на папку с бд:
    
        sudo chown -R $USER:$USER ./docker/databases
        sudo chmod -R 777 ./docker/databases
    
* Генерация ключа:
        
        docker-compose exec php php artisan key:generate
        
* Запуск миграций и сидов:
        
        docker-compose exec php php artisan migrate
        docker-compose exec php php artisan db:seed
        
* Установка **passport**:
        
        docker-compose exec php php artisan passport:install
