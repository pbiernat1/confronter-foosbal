build:
	- docker build -f docker/php/Dockerfile -t conf-php .

up:
	- docker compose -f docker-compose.yaml up -d

down:
	- docker compose -f docker-compose.yaml down

deps:
	- cd app && composer install

logs:
	- docker compose -f docker-compose.yaml logs -f
