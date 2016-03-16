<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSponsorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("sponsors", function(Blueprint $table) {
			$table->increments("id");
			$table->string("name");
			$table->string("logo");
			$table->string("slogan")->nullable();
			$table->string("website")->nullable();
			$table->unsignedInteger("fair_id");
			$table->unsignedInteger("sponsor_rank_id");
			$table->timestamps();

			$table->foreign("fair_id")->references("id")->on("fairs");
			$table->foreign("sponsor_rank_id")->references("id")->on("sponsor_ranks");
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("sponsors");
    }
}
