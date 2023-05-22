## Simple Task Management

This task is built using [Laravel Sail](https://laravel.com/docs/10.x/sail), This powerful tool helped me to dockerize the application smoothly.

[This is the postman collection containing the API requests](https://drive.google.com/file/d/13rkP2S3EP4FMHoBReboqxt7bleRBXySe/view?usp=share_link)

I used sanctum for authentication.

I used Service & Repository archeticture to make the code looks better and to acheive some of SOLID princibles.

I implemented queue for both sending email and resizing images to get the best performance, so to receive the email please change `MAIL_USERNAME` & `MAIL_PASSWORD` to your mailtrap account.

Also i made a postman automation to automatically fetch the token after login or signup and assign it for the rest of the requests.

All variables used in postman are related to the collection itself , so if you need to change any variable value just click on the collection in postman and choose `Variables` tab then edit whatever you want.

I made some test cases (Feature & Unit tests) to showcase how i can handle test cases, of course the coverage is not much but i think we won't depend on it for now.

### Steps to get the project up and running :
- use `docker-compose up` to run the project.
- Copy .env.example to .env `cp .env.example .env`
- then `docker-compose exec laravel.test bash`
- then `composer install`
- then `php artisan:migrate --seed`

Grab any test user which was made by the factory and start using the API with it.

So all functionalities plus the bonus points are implemented except for Kubernetes as i have no experience in it but i can learn it if needed.
