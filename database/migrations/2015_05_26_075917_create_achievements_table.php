<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAchievementsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('achievements', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('title');
            $table->string('path');
            $table->string('icon');
            $table->tinyInteger('difficulty');
            $table->integer('category_id');
            $table->integer('subcategory_id');
            $table->integer('points');
            $table->text('criteria_text');
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
		Schema::drop('achievements');
	}

}
