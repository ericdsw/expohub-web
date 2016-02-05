<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

		$this->call(SponsorRankTableSeeder::class);
		$this->call(UserTableSeeder::class);
		$this->call(FairTableSeeder::class);
		$this->call(CategoryTableSeeder::class);
		$this->call(SponsorTableSeeder::class);
		$this->call(MapTableSeeder::class);
		$this->call(EventTypeTableSeeder::class);
		$this->call(FairEventTableSeeder::class);
		$this->call(SpeakerTableSeeder::class);
		$this->call(NewsTableSeeder::class);
		$this->call(CommentTableSeeder::class);
		$this->call(StandTableSeeder::class);

        Model::reguard();
    }
}
