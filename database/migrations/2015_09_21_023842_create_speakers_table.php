<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpeakersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("speakers", function(Blueprint $table) {
			$table->increments("id");
			$table->string("name");
			$table->string("picture");
			$table->text("description")->nullable();
			$table->unsignedInteger("fair_event_id");
			$table->timestamps();

			$table->foreign("fair_event_id")->references("id")->on("fair_events");
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("speakers");
    }
}
