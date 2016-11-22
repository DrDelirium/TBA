<?php

namespace App\Http\Controllers;

use App\Trip;
use App\Airport;
use App\Flight;
use App\Http\Controllers\Controller;
use Log;
use Illuminate\Http\Request;

class TripController extends Controller
{

	public function index()
	{
		// Had to add a letter to the indexes because JSON restructure "arrays" when the indexes are numerical only.
		$trips = Trip::orderBy('name')->get();
		if ($trips)
		{
			$fullTripInfo = [];
			foreach($trips AS $trip)
			{
				$flights = json_decode($trip->flights);
				$flightInfo = [];
				if ($flights)
				{
					foreach($flights AS $fKey => $flight)
					{
						$iFlight = Flight::find($flight);
						$originAirport = Airport::where('code', '=', $iFlight->origin)->first()->toArray();
						$destinationAirport = Airport::where('code', '=', $iFlight->destination)->first()->toArray();
						$flightInfo[] = [
								'flightorder' => $fKey
							, 'id' => $iFlight->id
							, 'origin' => $originAirport
							, 'destination' => $destinationAirport
						];
					}
				}
				$fullTripInfo[] = [
						'id' => $trip->id
					, 'name' => $trip->name
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
				$flights = json_decode($trip->flights);
				$flightInfo = [];
				if ($flights)
				{
					foreach($flights AS $fKey => $flight)
					{
						$iFlight = Flight::find($flight);
						$originAirport = Airport::where('code', '=', $iFlight->origin)->first()->toArray();
						$destinationAirport = Airport::where('code', '=', $iFlight->destination)->first()->toArray();
						$flightInfo[] = [
								'flightorder' => $fKey
							, 'id' => $iFlight->id
							, 'origin' => $originAirport
							, 'destination' => $destinationAirport
						];
					}
				}
				$result = [
						'id' => $trip->id
					, 'name' => $trip->name
					, 'flightlist' => $flights
					, 'flights' => $flightInfo
				];
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
		//Log::info('Input Recieved: '.json_encode($request->input()));
		$fullTrip = [];
		$name = $request->input('name');
		$airports = $request->input('airports');
		$origin = $destination = null;
		foreach($airports AS $airport)
		{
			if (is_null($origin))
			{
				$origin = $airport;
				continue;
			}
			else
			{
				if (!is_null($destination))
				{
					$origin = $destination;
					$destination = null;
				}
			}
			if (is_null($destination))
			{
				$destination = $airport;
				// find the flight that correspond to this origin and destination
				$originAirport = Airport::find($origin);
				$destinationAirport = Airport::find($destination);
				$flight = Flight::where([
						['origin', '=', $originAirport->code],
						['destination', '=', $destinationAirport->code]
				])->first();
				if ($flight)
				{
					$fullTrip[] = $flight->id;
				}
			}
		}
		$trip = Trip::create([
				'name' => $name,
				'flights' => json_encode($fullTrip)
		]);
		return response()->json(['message' => 'success']);
	}

	public function deleteTrip($id)
	{
		$trip = Trip::find($id);
		$trip->delete();
		return response()->json('success');
	}

	public function updateTrip(Request $request)
	{
		//Log::info('Input Recieved: '.json_encode($request->input()));
		$id = $request->input('id');
		$trip = Trip::find($id);
		$trip->name = $request->input('name');
		$airports = $request->input('airports');
		$fullTrip = [];
		$origin = $destination = null;
		foreach($airports AS $airport)
		{
			if (is_null($origin))
			{
				$origin = $airport;
				continue;
			}
			else
			{
				if (!is_null($destination))
				{
					$origin = $destination;
					$destination = null;
				}
			}
			if (is_null($destination))
			{
				$destination = $airport;
				// find the flight that correspond to this origin and destination
				$originAirport = Airport::find($origin);
				$destinationAirport = Airport::find($destination);
				//Log::info('Searching for a flight between: '.$originAirport->code.' and '.$destinationAirport->code);
				$flight = Flight::where([
						['origin', '=', $originAirport->code],
						['destination', '=', $destinationAirport->code]
				])->first();
				if ($flight)
				{
					$fullTrip[] = $flight->id;
					//Log::info('Flight id: '.$flight->id.' found.');
				}
			}
		}
		$trip->flights = json_encode($fullTrip);
		$trip->save();
		return response()->json(['message' => 'success']);
	}

}
