<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAvgHeartRateToSessionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('session', function(Blueprint $table)
		{
			$table->string('avg_heart_rate');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('session', function(Blueprint $table)
		{
            $table->string('avg_heart_rate');
		});
	}

}
