<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("news", function (Blueprint $table) {
			$table->increments("id");
			$table->string("title");
			$table->text("content");
			$table->string("image");
			$table->unsignedInteger("fair_id");
			$table->timestamps();

			$table->foreign("fair_id")->references("id")->on("fairs");
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("news");
    }
}
