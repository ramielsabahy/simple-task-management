## Simple Task Management

This task is built using [Laravel Sail](https://laravel.com/docs/10.x/sail), This powerful tool helped me to dockerize the application smoothly.

[This is the postman collection containing the API requests](https://drive.google.com/file/d/13rkP2S3EP4FMHoBReboqxt7bleRBXySe/view?usp=share_link)

I used sanctum for authentication , Also i made a postman automation to automatically fetch the token after login or signup and assign it for the rest of the requests.

### Steps to get the project up and running :
- use `docker-compose up` to run the project.
- Copy .env.example to .env `cp .env.example .env`
- then `docker-compose exec laravel.test bash`
- then `composer install`
- then `php artisan:migrate --seed`

Grab any test user which was made by the factory and start using the API with it.
