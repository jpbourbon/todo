# Todo - a simple to-do list

This is a very simple to-do list. It's main purpose is to showcase the workings of a CRUD architecture.
It's built on Laravel 5.2, so the installation instructions are as follows:
<br>
* clone the repository;
* configure a virtual server pointing to the "public" folder or, if you're using Laravel valet, just type "valet link" at the root of the project;
* run "composer install" at the base of the project;
* configure the config/database.php and config/app.php. Alternatively just configure an .env file;
* create an empty database;
* run "php artisan migrate" at the base of the project;
* the url you defined on the vhost should be working now, or if using Laravel Valet your url is "todo.dev";