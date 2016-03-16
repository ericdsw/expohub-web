<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("attendance", function(Blueprint $table) {
			$table->unsignedInteger("user_id");
			$table->unsignedInteger("fair_event_id");
			$table->integer("score")->nullable();
			$table->timestamps();

			$table->primary(["user_id", "fair_event_id"]);

			$table->foreign("user_id")->references("id")->on("users");
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
        Schema::drop("attendance");
    }
}
