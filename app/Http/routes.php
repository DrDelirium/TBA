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

	/**
	 * For some reason, I am unable to use routes like '/', but have to use the full qualified route of '/TBA/public/'.
	 * I expect it is due to my web server setup, so these might have to be changed when going on a real server.
	 */

$app->get('/TBA/public/', function () use ($app) {
	return json_encode(['hello'=>'world']);
});

$app->get('/TBA/public/airports','AirportController@index');
$app->get('/TBA/public/airport/{id}','AirportController@getAirport');
$app->get('/TBA/public/trips','TripController@index');
$app->get('/TBA/public/trip/{id}','TripController@getTrip');
$app->post('/TBA/public/savetrip','TripController@saveTrip');
$app->post('/TBA/public/updatetrip','TripController@updateTrip');