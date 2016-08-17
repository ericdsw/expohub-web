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
			'fair_id' => $fairs->first(),
			'sponsor_rank_id' => $sponsorRanks->first()
		])->each(function (Sponsor $sponsor) use ($fairs, $sponsorRanks) {
			$sponsor->fair_id = $fairs->random();
			$sponsor->sponsor_rank_id = $sponsorRanks->random();
			$sponsor->save();
		});
    }
}
