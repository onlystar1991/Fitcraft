<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdministrativeAreaLevel1ToRidesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('rides', function(Blueprint $table)
		{
			$table->string('administrative_area_level_1')->after('locality');
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
