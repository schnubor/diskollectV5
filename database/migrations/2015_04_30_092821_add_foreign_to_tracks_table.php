<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignToTracksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tracks', function(Blueprint $table)
		{
			$table->foreign('vinyl_id')
				  ->references('id')
				  ->on('vinyls')
				  ->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tracks', function(Blueprint $table)
		{
			//
		});
	}

}
