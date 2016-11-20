<?php

namespace App\Http\Controllers;

use App\Trip;
use App\Airport;
use App\Flight;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TripController extends Controller
{

	public function index()
	{
		$trips = Trip::all();
		if ($trips)
		{
			$fullTripInfo = [];
			foreach($trips AS $trip)
			{
				$flights = json_decode($trip->flights);
				$flightInfo = [];
				if ($flights)
				{
					foreach($flights AS $flight)
					{
						$iFlight = Flight::find($flight);
						$originAirport = Airport::where('code', '=', $iFlight->origin)->first()->toArray();
						$destinationAirport = Airport::where('code', '=', $iFlight->destination)->first()->toArray();
						$flightInfo[$iFlight->id] = [
							  'origin' => $originAirport
							, 'destination' => $destinationAirport
						];
					}
				}
				$fullTripInfo[$trip->id] = [
					  'name' => $trip->name
					, 'flights' => $flightInfo
				];
			}
			return response()->json($fullTripInfo);
		}
		else
		{
			return response()->json(['error'=>'no trip currently recorded'], 500);
		}
	}

	public function getTrip($id)
	{
		if (intval($id) !== 0)
		{
			$trip = Trip::find(intval($id));
			if ($trip)
			{
				$result = $trip->toArray();
				$flights = json_decode($trip->flights);
				$flightInfo = [];
				if ($flights)
				{
					foreach($flights AS $flight)
					{
						$iFlight = Flight::find($flight);
						$originAirport = Airport::where('code', '=', $iFlight->origin)->first()->toArray();
						$destinationAirport = Airport::where('code', '=', $iFlight->destination)->first()->toArray();
						$flightInfo[$iFlight->id] = [
							  'origin' => $originAirport
							, 'destination' => $destinationAirport
						];
					}
				}
				$result['flights'] = $flightInfo;
				return response()->json($result);
			}
			else
			{
				return response()->json(['error'=>'unknown trip'], 500);
			}
		}
		else
		{
			return response()->json(['error'=>'wrong parameter'], 500);
		}
	}

	public function saveTrip(Request $request)
	{
		$trip = Trip::create($request->all());
		return response()->json($trip);
	}

	public function deleteTrip($id)
	{
		$trip = Trip::find($id);
		$trip->delete();
		return response()->json('success');
	}

	public function updateTrip(Request $request, $id)
	{
		$trip = Trip::find($id);
		$trip->name = $request->input('name');
		$trip->flights = json_encode($request->input('flights'));
		$trip->save();
		return response()->json($trip);
	}

}
