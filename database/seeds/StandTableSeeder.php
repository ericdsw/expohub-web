<?php

use ExpoHub\Fair;
use ExpoHub\Stand;
use Illuminate\Database\Seeder;

class StandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fairs = Fair::all()->lists('id');
		factory(Stand::class, 200)->create([
			'fair_id' => $fairs->random()
		]);
    }
}
