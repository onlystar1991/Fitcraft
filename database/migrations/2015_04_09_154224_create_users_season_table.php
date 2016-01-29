<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersSeasonTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_season', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('user_id');
            $table->timestamp('start');
            $table->timestamp('end');
            $table->tinyInteger('active')->default(1)->comment = '1-Yes; 0-No';
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
		Schema::drop('users_season');
	}

}
