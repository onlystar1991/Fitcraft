<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActivitiesIdToStravaParsingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('strava_parsings', function(Blueprint $table)
		{
            $table->integer('activities_id')->after('id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('strava_parsings', function(Blueprint $table)
		{
            $table->dropColumn('activities_id');
		});
	}

}
