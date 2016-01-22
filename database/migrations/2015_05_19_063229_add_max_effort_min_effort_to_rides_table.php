<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMaxEffortMinEffortToRidesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('rides', function(Blueprint $table)
		{
			$table->string('min_effort')->after('zone_5');
			$table->string('max_affort')->after('min_effort');
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
