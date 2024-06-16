# st3-microservices

## What is needed to run the project

1. Docker
2. Docker Compose
3. Node.js
4. NPM

## How to run the project

1. Clone the repository
2. Create docker network: `docker network create st3-microservices`
3. Go to **auth-and-countries** directory: `cd auth-and-countries`
4. Run command to install all vendors: `docker run --rm
   -u "$(id -u):$(id -g)"
   -v "$(pwd):/var/www/html"
   -w /var/www/html
   laravelsail/php83-composer:latest
   composer install --ignore-platform-reqs`
5. Copy **.env.example** to **.env**: `cp .env.example .env`
6. Create docker containers: `./vendor/bin/sail up -d`
7. Run migrations: `./vendor/bin/sail artisan migrate`
8. Run seeders: `./vendor/bin/sail artisan db:seed`
9. Go to **hotels-and-restaurants** directory
10. Run command to install all vendors: `docker run --rm
    -u "$(id -u):$(id -g)"
    -v "$(pwd):/var/www/html"
    -w /var/www/html
    laravelsail/php83-composer:latest
    composer install --ignore-platform-reqs`
11. Copy **.env.example** to **.env**: `cp .env.example .env`
12. Create docker containers: `./vendor/bin/sail up -d`
13. Run migrations: `./vendor/bin/sail artisan migrate`
14. Go to **reservations** directory
15. Run command to install all vendors: `docker run --rm
    -u "$(id -u):$(id -g)"
    -v "$(pwd):/var/www/html"
    -w /var/www/html
    laravelsail/php83-composer:latest
    composer install --ignore-platform-reqs`
16. Copy **.env.example** to **.env**: `cp .env.example .env`
17. Create docker containers: `./vendor/bin/sail up -d`
18. Run migrations: `./vendor/bin/sail artisan migrate`
19. Go to **frontend** directory
20. Run command to install all node modules: `npm install`
21. Run command to start the frontend: `npm run dev`
22. Frontend will be available at http://localhost:5173