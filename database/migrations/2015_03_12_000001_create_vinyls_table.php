<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVinylsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vinyls', function ($table)
        {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->string('artwork')->nullable();
			$table->string('artist');
			$table->string('title');
			$table->string('label')->nullable();
			$table->string('genre')->nullable();
			$table->float('price')->nullable();
			$table->string('country')->nullable();
			$table->integer('size')->unsigned()->nullable();
			$table->integer('count')->unsigned()->nullable();
			$table->string('color')->nullable();
			$table->string('type')->nullable();
			$table->string('notes')->nullable();
			$table->string('releasedate')->nullable();
			$table->string('releasetype')->nullable();
			$table->string('catno')->nullable();
			$table->string('weight')->nullable();
			$table->string('release_id')->nullable();
			$table->string('discogs_uri')->nullable();
			$table->string('spotify_id')->nullable();
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
		Schema::drop('vinyls');
	}

}
