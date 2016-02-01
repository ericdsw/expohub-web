<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannedUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("banned_users", function(Blueprint $table) {
			$table->unsignedInteger("fair_id");
			$table->unsignedInteger("user_id");
			$table->timestamps();

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
        Schema::drop("banned_users");
    }
}
