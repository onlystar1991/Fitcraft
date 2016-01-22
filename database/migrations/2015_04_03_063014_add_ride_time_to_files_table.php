<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRideTimeToFilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('files', function(Blueprint $table)
        {
            //1-New, 0-Old
            $table->tinyInteger('status')->default(1);
            $table->integer('session_timestamp');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('files', function(Blueprint $table)
        {
            $table->tinyInteger('status')->default(1);
            $table->integer('session_timestamp');
        });
	}

}
