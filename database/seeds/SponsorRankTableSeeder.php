<?php

use ExpoHub\SponsorRank;
use Illuminate\Database\Seeder;

class SponsorRankTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(SponsorRank::class, 5)->create();
    }
}
