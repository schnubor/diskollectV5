<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTracksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tracks', function ($table)
        {
			$table->increments('id');
			$table->integer('vinyl_id')->unsigned();
			$table->string('number')->nullable();
			$table->string('artist')->nullable();
			$table->string('title')->nullable();
			$table->string('duration')->nullable();
 			$table->timestamps();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tracks');
	}

}
