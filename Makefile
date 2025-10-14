up:
	- docker compose -f docker-compose.yaml up -d

down:
	- docker compose -f docker-compose.yaml down

dependencies:
	- docker compose -f docker-compose.yaml exec 

watchdog:
	- docker compose -f docker-compose.yaml logs -f
