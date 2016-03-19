<?php

use ExpoHub\EventType;
use ExpoHub\Fair;
use ExpoHub\FairEvent;
use ExpoHub\User;
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
		$fairs 		= Fair::has('categories')->get()->lists('id');
		$eventTypes = EventType::all()->lists('id');
		$users 		= User::all()->lists('id');

        factory(FairEvent::class, 50)->create([
			'fair_id' => $fairs->first(),
			'event_type_id' => $eventTypes->first()
		])->each(function(FairEvent $fairEvent) use ($fairs, $eventTypes, $users) {

			$fairId 		= $fairs->random();
			$currentFair 	= Fair::find($fairId);

			$fairEvent->fair_id = $fairId;
			$fairEvent->event_type_id = $eventTypes->random();
			$fairEvent->categories()->attach($currentFair->categories->lists('id')->random());

			if(mt_rand(1, 10) < 5) {
				$users->random(3)->each(function($userId) use ($fairEvent) {
					$fairEvent->attendingUsers()->attach($userId);
				});
			}

			$fairEvent->save();

		});
    }
}
