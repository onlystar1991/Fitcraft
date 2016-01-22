<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('activity', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('file_id');
            $table->string('timestamp');
            $table->string('total_timer_time');
            $table->string('num_sessions');
            $table->string('type');
            $table->string('event');
            $table->string('event_type');
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
        Schema::drop('activity');
	}

}
