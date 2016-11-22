# Trip Builder API using the Lumen PHP Framework

The Trip Builder API is a simple API to see airports, see each flights departing from an airport and construct trips based of the possible flight paths provided.

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Official Documentation

Documentation for the framework can be found on the [Lumen website](http://lumen.laravel.com/docs).

Clone or download this project file to your system, then use composer install to get all the dependencies.

Don't forget to change the relevant information in the .env file.

Also, due to how my local server was setup, you might need to check the /app/Http/routes.php file to correct it for your server.

(Make sure you have created the database and its associated user, as seen in the .env file) Create the required tables with artisan migrate, and then fill the tables with artisan db:seed.

For a bare-minimum front-end, you can get the files from [Trip Builder Client](https://github.com/DrDelirium/TBC) which is a simple HTML/jQuery page to access the API.

The API will allow for the following entry points,

RestFull action: GET:
- airports: The alphabetically sorted list of all airports in the system.
- airport/{id}: One airport, including all the possible destinations from it.
- trips: The alphabetically sorted list of all the trips saved in the system.
- trip: One trip, including all the previously saved origin airports and destination airport of each flight.

RestFull action: POST:
- savetrip
- updatetrip

## Installation

## License

The Lumen framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
