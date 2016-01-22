<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoryIdToAchievementsCriteriaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('achievements_criteria', function(Blueprint $table)
		{
			$table->integer('category_id')->unsigned()->after('id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('achievements_criteria', function(Blueprint $table)
		{
			//
		});
	}

}
