up:
	- docker compose -f docker-compose.yaml up -d

down:
	- docker compose -f docker-compose.yaml down

deps:
	- cd app && composer install

logs:
	- docker compose -f docker-compose.yaml logs -f
