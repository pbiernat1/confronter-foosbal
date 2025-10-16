# confronter-foosbal
Test task for Confronter interview

## To run app execute following commands:

```cd app```

```cp .env.dev .env```

```composer install --ignore-platform-reqs```

```cd ..```

```make build```

```make up```

Login into PHP docker container and execute doctrine:schema:update

```docker compose -f docker-compose.yaml exec php /bin/sh```

```./bin/console doctrine:schema:update --force```

App gonna be available at http://127.0.0.1:30080/

## To run test execute following commands:

```make test-unit```

```make test-func```

IMPORTANT: Install dependencies from local env (not inside docker) with composer(which has to be installed locally)