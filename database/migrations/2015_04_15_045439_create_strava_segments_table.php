<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStravaSegmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('strava_segments', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('activities_id');
            $table->float('distance');
            $table->float('average_grade');
            $table->float('maximum_grade');
            $table->float('elevation_high');
            $table->float('elevation_low');
            $table->string('start_lat');
            $table->string('start_lng');
            $table->string('end_start_lat');
            $table->string('end_start_lng');
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
		Schema::drop('strava_segments');
	}

}
