<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEstimatedPowerToLapTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('lap', function(Blueprint $table)
		{
			$table->string('estimated_power')->defualt(0)->after('max_power');
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
