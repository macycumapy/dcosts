# Настройка
* Настройте .env
* Запуск контейнеров
  
        docker-compose up -d --build    
    
* Установка прав на папку с бд
    
        sudo chown -R $USER:$USER ./docker/databases
        sudo chmod -R 777 ./docker/databases
    
* Запуск миграций и сидов
        
        docker-compose exec php php artisan migrate
        docker-compose exec php php artisan db:seed
        
# PHPSTORM
###### Подробная инстукция настройки phpstorm с использованием docker:
https://blog.denisbondar.com/post/phpstorm_docker_xdebug
    
    sudo chmod a+rwx /var/run/docker.sock 
