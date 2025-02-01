init:
		docker-compose up -d
		docker-compose exec app composer install
		docker-compose exec app cp .env.example .env
		docker-compose exec app php artisan key:generate
		docker-compose exec app php artisan storage:link
		docker-compose exec app php artisan migrate
		docker-compose exec app php artisan db:seed
		chmod 777 -R src/storage/
		docker-compose exec app npm install
		docker-compose exec app npm run dev
up:
		docker-compose up -d
down:
		docker-compose down
app:
		docker-compose exec --user=www-data app bash
web:
		docker-compose exec web sh
db:
		docker-compose exec db bash

start:
	docker-compose start
stop:
	docker-compose stop
dev:
	docker-compose exec app npm run dev
