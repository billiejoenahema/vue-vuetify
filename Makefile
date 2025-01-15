init:
		docker-compose up -d
		docker-compose exec app composer install
		docker-compose exec app cp .env.example .env
		docker-compose exec app php artisan key:generate
		docker-compose exec app php artisan migrate
		docker-compose exec app php artisan db:seed
		docker-compose exec app npm install
		docker-compose exec app npm run dev
		docker-compose exec app php artisan storage:link
up:
		docker-compose up -d
down:
		docker-compose down
app:
		docker-compose exec --user=www-data app bash
db:
		docker-compose exec db bash

dev:
	docker-compose exec app npm run dev
