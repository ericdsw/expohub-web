<?php

use ExpoHub\Fair;
use ExpoHub\News;
use Illuminate\Database\Seeder;

class NewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fairs = Fair::all()->lists('id');
		factory(News::class, 100)->create([
			'fair_id' => $fairs->random()
		]);
    }
}
