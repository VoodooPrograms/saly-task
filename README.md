## How to run this project

### Step 1. Build images

To build project type in console
```
docker-compose up --build
```

### Step 2. Install all dependencies
```
docker-compose exec api composer install
```

### Step 3. Create database
```
docker-compose exec api symfony console doctrine:database:create --if-not-exists
```

### Step 4. Run migration
```
docker-compose exec api symfony console doctrine:migrations:migrate
```

### Step 5.

Import Postman collection which is located at `docs/Saly.postman_collection.json`

After this you should be able to run every endpoint from `Saly` folder.

### Run tests

To run tests type in console

```
docker-compose exec api ./vendor/bin/phpunit
```