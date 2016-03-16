<?php

use ExpoHub\Fair;
use ExpoHub\User;
use Illuminate\Database\Seeder;

class FairTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$users = User::all()->lists('id');
        factory(Fair::class, 100)->create([
			'user_id' => $users->random()
		]);
    }
}
