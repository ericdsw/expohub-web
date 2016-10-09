<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("fair_events", function (Blueprint $table) {
			$table->increments("id");
			$table->string("title");
			$table->string("image")->nullable();
			$table->text("description");
			$table->dateTime("date");
			$table->string("location");
			$table->unsignedInteger("fair_id");
			$table->unsignedInteger("event_type_id");
			$table->timestamps();

			$table->foreign("fair_id")->references("id")->on("fairs");
			$table->foreign("event_type_id")->references("id")->on("event_types");
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("fair_events");
    }
}
