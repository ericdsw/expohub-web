<?php

use ExpoHub\FairEvent;
use Illuminate\Database\Seeder;

class SpeakerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fairEvents = FairEvent::all()->lists('id');
		factory(\ExpoHub\Speaker::class, 50)->make([
			'fair_event_id' => $fairEvents->random()
		]);
    }
}
