<?php

# database/seeds/FlightsTableSeeder.php

use App\Airport;
use App\Flight;
use Illuminate\Database\Seeder;

class FlightsTableSeeder extends Seeder
{

	public function run()
	{
		$airports = Airport::all()->toArray();
		$airNum = count($airports);
		foreach($airports AS $aX => $airport)
		{
			$origin = $airport['code'];
			$i = 0;
			$num = mt_rand(3, 6);
			while($i < $num)
			{
				$destX = $aX;
				while($destX === $aX)
				{
					$destX = mt_rand(0, ($airNum-1));
				}
				$destination = $airports[$destX]['code'];
				Flight::create([
					'origin' => $origin,
					'destination' => $destination
				]);
				$i++;
			}
		}
	}

}
