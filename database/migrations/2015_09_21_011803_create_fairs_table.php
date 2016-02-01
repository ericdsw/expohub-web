<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("fairs", function(Blueprint $table) {
			$table->increments("id");
			$table->string("name");
			$table->string("image");
			$table->string("description");
			$table->string("website")->nullable();
			$table->dateTime("starting_date");
			$table->dateTime("ending_date");
			$table->string("address");
			$table->decimal("latitude", 10, 6);
			$table->decimal("longitude", 10, 6);
			$table->unsignedInteger("user_id");
			$table->timestamps();

			$table->foreign("user_id")->references("id")->on("users");
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("fairs");
    }
}
