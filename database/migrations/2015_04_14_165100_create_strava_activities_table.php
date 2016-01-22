<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStravaActivitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('strava_activities', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('activities_id');
            $table->integer('user_id');
            $table->string('name');
            $table->string('distance');
            $table->integer('moving_time');
            $table->integer('elapsed_time');
            $table->string('type');
            $table->string('start_date');
            $table->string('start_lat');
            $table->string('start_lng');
            $table->string('end_start_lat');
            $table->string('end_start_lng');
            $table->boolean('private');
            $table->string('average_speed');
            $table->string('max_speed');
            $table->string('average_cadence');
            $table->string('average_temp');
            $table->string('device_watts');
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
		Schema::drop('strava_activities');
	}

}
