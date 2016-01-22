<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNameToRidesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('rides', function(Blueprint $table)
		{
			$table->string('name')->after('file_id');
            $table->string('locality')->after('elevation');
            $table->string('country')->after('locality');
            $table->string('postal_code')->after('country');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('rides', function(Blueprint $table)
		{
			//
		});
	}

}
