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
			'fair_id' => $fairs->first()
		])->each(function (Map $map) use ($fairs) {
			$map->fair_id = $fairs->random();
			$map->save();
		});
    }
}
