<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeviceInfoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('device_info', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('file_id');
            $table->string('timestamp');
            $table->string('serial_number');
            $table->string('manufacturer');
            $table->string('product');
            $table->string('software_version');
            $table->string('device_index');
            $table->string('device_type');
            $table->string('unknown');
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
        Schema::drop('device_info');
	}

}
