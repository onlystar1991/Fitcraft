<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddXpLap extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lap', function(Blueprint $table)
        {
            $table->integer('xp')->after('sport');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lap', function(Blueprint $table)
        {
            $table->dropColumn('xp');
        });
    }
}
