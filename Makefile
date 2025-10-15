build:
	- docker build -f docker/php/Dockerfile -t conf-php --no-cache .

up:
	- docker compose -f docker-compose.yaml up -d

down:
	- docker compose -f docker-compose.yaml down

# WARNING: need to have locally installed composer
deps:
	- cd app && composer install

logs:
	- docker compose -f docker-compose.yaml logs -f
