<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBonusXpTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bonus_xp', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('ride_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('zone');
            $table->string('xp');
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
		Schema::drop('bonus_xp');
	}

}
