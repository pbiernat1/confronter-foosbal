# confronter-foosbal
Test task for Confronter interview

## To run app execute following commands:

```cd app```

```cp .env.dev .env```

```composer install --ignore-platform-reqs```

```make build```

```make up```

Login into PHP docker container and execute doctrine:schema:update

## To run test execute following commands:
```make test-unit```

```make test-func```

IMPORTANT: Install dependencies from local env (not inside docker) with composer(which has to be installed locally)