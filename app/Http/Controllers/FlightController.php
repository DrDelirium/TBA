<?php

namespace App\Http\Controllers;

use App\Flight;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FlightController extends Controller
{

	public function index()
	{
		$flights = Flight::all();
		return response()->json($flights);
	}

	public function getFlight($id)
	{
		$flight = Flight::find($id);
		return response()->json($flight);
	}

	public function saveFlight(Request $request)
	{
		$flight = Flight::create($request->all());
		return response()->json($flight);
	}

	public function deleteFlight($id)
	{
		$flight = Flight::find($id);
		$flight->delete();
		return response()->json('success');
	}

	public function updateFlight(Request $request, $id)
	{
		$flight = Flight::find($id);
		$flight->origin = $request->input('origin');
		$flight->destination = $request->input('destination');
		$flight->save();
		return response()->json($flight);
	}

}
