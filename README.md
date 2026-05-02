# Setup project

## Step 1: Setup docker

- [Install docker](https://docs.docker.com/compose/install/)

```
1. cp .env.example .env

2. docker-compose build

3. docker-compose up -d
```

## Step 2: Setup laravel

```
1. docker exec -it container_name bash

2. mkdir storage

3. cd storage/

4. mkdir -p framework/{sessions,views,cache} - if not has this folder

5. cd ..

6. composer install

7. cp .env.example .env

8. php artisan key:generate

9. php artisan migrate

10. php artisan db:seed

11. chmod -R o+w storage/
```

## Step 3: When change config queue

```
1. docker-compose down
2. docker-compose build
3. docker-compose up -d

OR

1. supervisorctl restart all
```

## NOTE

```
1. When change config crontab
    - cron reload
```
