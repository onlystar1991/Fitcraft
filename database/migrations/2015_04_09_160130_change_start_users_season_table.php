<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeStartUsersSeasonTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users_season', function(Blueprint $table)
		{
            $table->timestamp('start')->default(DB::raw('CURRENT_TIMESTAMP'))->change();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users_season', function(Blueprint $table)
		{
            $table->timestamp('start');
		});
	}

}
