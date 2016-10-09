<?php

use ExpoHub\FairEvent;
use ExpoHub\Speaker;
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
		factory(Speaker::class, 50)->make([
			'fair_event_id' => $fairEvents->first()
		])->each(function (Speaker $speaker) use ($fairEvents) {
			$speaker->fair_event_id = $fairEvents->random();
			$speaker->save();
		});
    }
}
