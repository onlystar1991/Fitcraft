<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStravaParsingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('strava_parsings', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('total_count');
            $table->integer('completed_count');
            $table->string('completed_all')->default('N');
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
		Schema::drop('strava_parsings');
	}

}
