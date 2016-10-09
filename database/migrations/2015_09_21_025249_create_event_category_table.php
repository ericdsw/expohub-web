<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("event_category", function (Blueprint $table) {
			$table->unsignedInteger("fair_event_id");
			$table->unsignedBigInteger("category_id");

			$table->primary(["fair_event_id", "category_id"]);
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
        Schema::drop("event_category");
    }
}
