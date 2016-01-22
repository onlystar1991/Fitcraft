<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAvgHeartRateToLapTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('lap', function(Blueprint $table)
		{
			$table->float('avg_heart_rate')->after('max_cadence');
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
