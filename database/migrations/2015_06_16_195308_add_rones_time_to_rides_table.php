<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRonesTimeToRidesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('rides', function(Blueprint $table)
		{
			$table->integer('zone_0_time')->after('zone_5');
			$table->integer('zone_1_time')->after('zone_0_time');
			$table->integer('zone_2_time')->after('zone_1_time');
			$table->integer('zone_3_time')->after('zone_2_time');
			$table->integer('zone_4_time')->after('zone_3_time');
			$table->integer('zone_5_time')->after('zone_4_time');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('rides', function(Blueprint $table)
		{
			//
		});
	}

}
