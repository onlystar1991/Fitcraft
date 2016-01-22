<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMovingTimeToLapTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('lap', function(Blueprint $table)
		{
			$table->integer('moving_time')->after('total_timer_time');
            $table->integer('idle_time')->after('moving_time');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('lap', function(Blueprint $table)
		{
			//
		});
	}

}
