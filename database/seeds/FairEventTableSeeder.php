<?php

use ExpoHub\EventType;
use ExpoHub\Fair;
use ExpoHub\FairEvent;
use Illuminate\Database\Seeder;

class FairEventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$fairs = Fair::all()->lists('id');
		$eventTypes = EventType::all()->lists('id');
        factory(FairEvent::class, 50)->create([
			'fair_id' => $fairs->random(),
			'event_type_id' => $eventTypes->random()
		]);
    }
}
