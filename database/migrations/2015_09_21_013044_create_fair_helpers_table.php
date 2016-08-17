<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFairHelpersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("fair_helpers", function (Blueprint $table) {
			$table->unsignedInteger("fair_id");
			$table->unsignedInteger("user_id");

			$table->foreign("fair_id")->references("id")->on("fairs");
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
        Schema::drop("fair_helpers");
    }
}
