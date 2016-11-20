<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/TBA/public/', function () use ($app) {
    //return $app->version();
	//return $app->welcome();
	return json_encode(['hello'=>'world']);
});

$app->get('/TBA/public/airports','AirportController@index');
$app->get('/TBA/public/airport/{id}','AirportController@getAirport');
$app->get('/TBA/public/trips','TripController@index');
$app->get('/TBA/public/trip/{id}','TripController@getTrip');