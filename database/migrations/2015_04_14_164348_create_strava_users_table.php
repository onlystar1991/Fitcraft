<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStravaUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('strava_users', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('user_id');
            $table->integer('strava_id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('sex',1);
            $table->string('email');
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
		Schema::drop('strava_users');
	}

}
