<?php

use ExpoHub\Fair;
use ExpoHub\Map;
use Illuminate\Database\Seeder;

class MapTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$fairs = Fair::all()->lists('id');
        factory(Map::class, 20)->create([
			'fair_id' => $fairs->random()
		]);
    }
}
