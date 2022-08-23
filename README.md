# Faculty Management system

## Run these commands in order for a successful setup

- Delete composer.lock file if available 
- composer update 
- cp .env.example .env
- php artisan key:generate
- create database with the credentials and replace accordingly in the .env file created above
- php artisan serve
- php artisan migrate
- php artisan jwt:secret

Now u can use the APIs in the  [routes/api.php]()

