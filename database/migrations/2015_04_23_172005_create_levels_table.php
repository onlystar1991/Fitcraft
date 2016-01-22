<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLevelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('levels', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('level');
            $table->string('xp_second');
            $table->string('xp_hour');
            $table->string('xp_required');
            $table->string('xp_objective');
            $table->string('xp_rival');
            $table->string('xp_tournament');
            $table->string('hours_required');
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
		Schema::drop('levels');
	}

}
