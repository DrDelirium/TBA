<?php

namespace App\Http\Controllers;

use App\Flight;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FlightController extends Controller
{

	/**
	 * Return all the flights in the system. This will return a lot of rows, use with care.
	 *
	 * @return string JSON
	 */
	public function index()
	{
		$flights = Flight::all();
		return response()->json($flights);
	}

	/**
	 * Return one flight composed of an id, an origin airport code and destination airport code.
	 *
   * @param mixed $id
	 *
	 * @return string JSON
	 */
	public function getFlight($id)
	{
		$flight = Flight::find($id);
		return response()->json($flight);
	}

	/**
	 * Creates one flight. Not currently implemented in the API.
	 *
	 * @return string JSON
	 */
	public function saveFlight(Request $request)
	{
		$flight = Flight::create($request->all());
		return response()->json($flight);
	}

	/**
	 * Deletes one flight. Not currently implemented in the API.
	 *
   * @param mixed $id
	 *
	 * @return string JSON
	 */
	public function deleteFlight($id)
	{
		$flight = Flight::find($id);
		$flight->delete();
		return response()->json('success');
	}

	/**
	 * Return the updated information on a flight. Not currently implemented in the API.
	 *
   * @param mixed $id
	 *
	 * @return string JSON
	 */
	public function updateFlight(Request $request, $id)
	{
		$flight = Flight::find($id);
		$flight->origin = $request->input('origin');
		$flight->destination = $request->input('destination');
		$flight->save();
		return response()->json($flight);
	}

}
