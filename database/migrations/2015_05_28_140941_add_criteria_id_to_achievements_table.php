<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCriteriaIdToAchievementsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('achievements', function(Blueprint $table)
		{
			$table->integer('criteria_id')->unsigned()->after('id');
            $table->string('criteria_value')->after('criteria_text');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('achievements', function(Blueprint $table)
		{
			//
		});
	}

}
