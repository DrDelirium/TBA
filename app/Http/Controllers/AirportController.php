<?php

namespace App\Http\Controllers;

use App\Airport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AirportController extends Controller
{

	/**
	 * Return the list of all airports.
	 *
	 * @return string JSON
	 */
	public function index()
	{
		$airports = Airport::orderBy('name')->get();
		return response()->json($airports);
	}

	/**
	 * Return one airport with a list of all destination airports that starts from there.
	 *
   * @param mixed $id
	 *
	 * @return string JSON
	 */
	public function getAirport($id)
	{
		$iID = intval($id);
		if ($iID !== 0)
		{
			$airport = Airport::find(intval($iID));
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
						$destinations['F'.$flight->id] = $destination;
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

	/**
	 * Return the saved airport information. Not currently implemented in the API.
	 *
	 * @return string JSON
	 */
	public function saveAirport(Request $request)
	{
		$airport = Airport::create($request->all());
		return response()->json($airport);
	}

	/**
	 * Deletes one airport. Not currently implemented for the API.
	 *
   * @param mixed $id
	 *
	 * @return string JSON
	 */
	public function deleteAirport($id)
	{
		$iID = intval($id);
		if ($iID !== 0)
		{
			$airport = Airport::find($iID);
			if ($airport)
			{
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

	/**
	 * Updates one airport. Not currently implemented in the API.
	 *
	 * @return string JSON
	 */
	public function updateAirport(Request $request)
	{
		$iID = intval($id);
		if ($iID !== 0)
		{
			$airport = Airport::find($iID);
			if ($airport)
			{
				$airport->name = $request->input('name');
				$airport->country = $request->input('country');
				$airport->code = $request->input('code');
				$airport->save();
				return response()->json($airport);
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

}

