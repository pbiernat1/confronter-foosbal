build:
	- docker build -f docker/php/Dockerfile -t conf-php --no-cache .

up:
	- docker compose -f docker-compose.yaml up -d

down:
	- docker compose -f docker-compose.yaml down

# WARNING: need to have locally installed composer
deps:
	- cd app && composer install

test-func:
	- docker compose -f docker-compose.yaml exec php /bin/sh -c "./bin/phpunit --testsuite='Functional Tests'"

test-unit:
	- docker compose -f docker-compose.yaml exec php /bin/sh -c "./bin/phpunit --testsuite='Unit Tests'"

logs:
	- docker compose -f docker-compose.yaml logs -f
