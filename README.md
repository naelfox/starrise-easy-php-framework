# StarRise Framework
PHP MVC framework with POO
> click on the star to support this project 

3 pillars of a good project well done are quality, performance and maintainability.

Aimed at giving support to develop your projects quickly

## Template system
The mustache symbol is {{ }} (double module symbol) which is used both to open and close the template that will apply

##  Database configuration
create an .env file and insert your database data into it. You can follow the template from .env.example.
In your .env you can create any variable that contains passwords or sensitive data that need to be kept safe.

if you don't need to configure the database in your project, you can use the `Book` class, which saves data without needing to insist.

## File system
`APP` -> all backend features.
`Resources` -> all front end html, js and css features.

####  App
The basic layers mvc `controllers`, `models` and routing and requests (`http`). `Routes` to create your routes.

`Core` -> The core for the necessary functioning of the system and libraries

`Utils` -> Utils all the utilities that you can get as a library.
