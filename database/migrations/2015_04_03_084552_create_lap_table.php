<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLapTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('lap', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('file_id');
            $table->string('timestamp');
            $table->string('start_time');
            $table->string('start_position_lat');
            $table->string('start_position_long');
            $table->string('end_position_lat');
            $table->string('end_position_long');
            $table->string('total_elapsed_time');
            $table->string('total_timer_time');
            $table->string('total_distance');
            $table->string('total_cycles');
            $table->string('unknown');
            $table->string('message_index');
            $table->string('total_calories');
            $table->string('total_fat_calories');
            $table->string('avg_speed');
            $table->string('max_speed');
            $table->string('total_ascent');
            $table->string('total_descent');
            $table->string('event');
            $table->string('event_type');
            $table->string('avg_cadence');
            $table->string('max_cadence');
            $table->string('lap_trigger');
            $table->string('sport');
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
        Schema::drop('lap');
	}

}
