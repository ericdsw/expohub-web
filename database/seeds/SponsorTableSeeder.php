<?php

use ExpoHub\Fair;
use ExpoHub\Sponsor;
use ExpoHub\SponsorRank;
use Illuminate\Database\Seeder;

class SponsorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fairs = Fair::all()->lists('id');
		$sponsorRanks = SponsorRank::all()->lists('id');
		factory(Sponsor::class, 10)->make([
			'fair_id' => $fairs->random(),
			'sponsor_rank_id' => $sponsorRanks->random()
		]);
    }
}
