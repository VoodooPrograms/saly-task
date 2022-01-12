## How to run this project

### Step 1.

To build project type in console
```
docker-compose up --build
```

### Step 2.

Import Postman collection which is located at `docs/Saly.postman_collection.json`

After this you should be able to run every endpoint from `Saly` folder.

### Run tests

To run tests type in console

```
docker-compose exec api ./vendor/bin/phpunit
```