<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("stands", function(Blueprint $table) {
			$table->increments("id");
			$table->string("name");
			$table->text("description");
			$table->string("image");
			$table->unsignedInteger("fair_event_id");

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
        Schema::drop("stands");
    }
}
