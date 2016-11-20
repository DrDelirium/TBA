<?php

namespace App\Http\Controllers;

use App\Airport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AirportController extends Controller
{

	public function index()
	{
		$airports = Airport::orderBy('name')->get();
		return response()->json($airports);
	}

	public function getAirport($id)
	{
		if (intval($id) !== 0)
		{
			$airport = Airport::find(intval($id));
			if ($airport)
			{
				$result = $airport->toArray();
				$flights = $airport->origin;
				if ($flights)
				{
					$destinations = [];
					foreach($flights AS $flight)
					{
						$destination = Airport::where('code', $flight->destination)->first()->toArray();
						$destinations[$flight->id] = $destination;
					}
					uasort($destinations, function ($a, $b) {
		          return strnatcasecmp($a['name'],$b['name']);
					});
					$result['destinations'] = $destinations;
				}
				return response()->json($result);
			}
			else
			{
				return response()->json(['error'=>'unknown airport'], 500);
			}
		}
		else
		{
			return response()->json(['error'=>'wrong parameter'], 500);
		}
	}

	public function saveAirport(Request $request)
	{
		$airport = Airport::create($request->all());
		return response()->json($airport);
	}

	public function deleteAirport($id)
	{
		$airport = Airport::find($id);
		$origins = $airport->origin;
		if ($origins)
		{
			foreach($origins AS $flight)
			{
				$flight->delete();
			}
		}
		$destinations = $airport->destinations;
		if ($destinations)
		{
			foreach($destinations AS $flight)
			{
				$flight->delete();
			}
		}
		$airport->delete();
		return response()->json('success');
	}

	public function updateAirport(Request $request, $id)
	{
		$airport = Airport::find($id);
		$airport->name = $request->input('name');
		$airport->country = $request->input('country');
		$airport->code = $request->input('code');
		$airport->save();
		return response()->json($airport);
	}

	// Sort a class by one of its members (even lowercase!!!)
	public static function recordSort($records, $field, $reverse=false)
	{
			$hash = [];

			foreach($records as $key => $record)
			{
					$record['xyzKey'] = $key;
					$hash[$record[$field].$key] = $record;
			}

			($reverse)? krsort($hash) : ksort($hash);

			$newrecords = [];

			foreach($hash as $record)
			{
					$oldKey = $record['xyzKey'];
					unset($record['xyzKey']);
					$newrecords[$oldKey] = $record;
			}

			return $newrecords;
	}

	public function nameSort($a,$b) {
		return $a['name']>$b['name'];
	}

}

