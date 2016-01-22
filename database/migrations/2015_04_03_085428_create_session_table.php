<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('session', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('file_id');
            $table->string('start_time');
            $table->string('start_position_lat');
            $table->string('start_position_long');
            $table->string('total_elapsed_time');
            $table->string('total_timer_time');
            $table->string('total_distance');
            $table->string('total_cycles');
            $table->string('nec_lat');
            $table->string('nec_long');
            $table->string('swc_lat');
            $table->string('swc_long');
            $table->string('message_index');
            $table->string('total_calories');
            $table->string('total_fat_calories');
            $table->string('avg_speed');
            $table->string('max_speed');
            $table->string('total_ascent');
            $table->string('total_descent');
            $table->string('first_lap_index');
            $table->string('num_laps');
            $table->string('event');
            $table->string('event_type');
            $table->string('sport');
            $table->string('sub_sport');
            $table->string('avg_cadence');
            $table->string('max_cadence');
            $table->string('trigger');
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
        Schema::drop('session');
	}

}
