<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdUriToVinylsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('vinyls', function(Blueprint $table)
		{
			$table->string('release_id')->nullable();
			$table->string('discogs_uri')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('vinyls', function(Blueprint $table)
		{
			//
		});
	}

}
