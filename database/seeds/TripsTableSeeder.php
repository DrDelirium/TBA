<?php

# database/seeds/FlightsTableSeeder.php

use App\Flight;
use App\Trip;
use Illuminate\Database\Seeder;

class TripsTableSeeder extends Seeder
{

	public function run()
	{
		$tripNum = mt_rand(5, 10);
		for($i = 0; $i < $tripNum; $i++)
		{
			$name = 'Random Trip #'.$i;
			$flights = [];
			$flightsNum = mt_rand(3, 6);
			for($j = 0; $j < $flightsNum; $j++)
			{
				if (empty($flights))
				{
					$flight = Flight::orderByRaw('RAND()')->take(1)->first();
				}
				else
				{
					$flight = $nextDestination;
				}
				if (!in_array($flight->id, $flights))
				{
					$flights[] = $flight->id;
					$nextDestination = Flight::where('origin', '=', $flight->destination)->orderByRaw('RAND()')->take(1)->first();
				}
				else
				{
					$j--;
				}
			}
			Trip::create([
				'name' => $name,
				'flights' => json_encode($flights)
			]);
		}
	}

}
