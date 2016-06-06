<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function ($table)
        {
			$table->increments('id');
			$table->string('email')->unique();
			$table->string('username', 20)->unique();
			$table->string('name', 50)->nullable();
			$table->string('website', 50)->nullable();
			$table->string('location', 50)->nullable();
			$table->string('image')->default('/images/PH_user_large.png');
			$table->string('description', 140)->nullable();
			$table->string('password', 60);
			$table->string('password_temp', 60)->nullable();
			$table->string('code', 60)->nullable();
			$table->string('discogs_access_token')->nullable();
			$table->string('discogs_access_token_secret')->nullable();
			$table->string('discogs_username')->nullable();
			$table->string('discogs_uri')->nullable();
			$table->string('currency')->nullable();
			$table->boolean('active')->default(0);
			$table->boolean('email_new_follower')->default(1);
            $table->enum('collection_visibility', ['everyone', 'noone', 'follower']);
            $table->enum('statistics_visibility', ['everyone', 'noone', 'follower']);
			$table->rememberToken();
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
		Schema::drop('users');
	}

}
