<?php

use ExpoHub\EventType;
use Illuminate\Database\Seeder;

class EventTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(EventType::class, 2)->create();
    }
}
