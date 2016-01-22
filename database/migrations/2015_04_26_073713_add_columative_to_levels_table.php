<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumativeToLevelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('levels', function(Blueprint $table)
		{
			$table->string('columative')->after('hours_required');
			$table->string('hours')->after('columative');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('levels', function(Blueprint $table)
		{
			//
		});
	}

}
