<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGreyIcons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('awards', function(Blueprint $table)
        {
            $table->string('icon_grey',255)->after('icon');
        });
        Schema::table('cards', function(Blueprint $table)
        {
            $table->string('icon_grey',255)->after('icon');
        });

        DB::unprepared('
          update cards set icon_grey = icon
        ');

        DB::unprepared('
          update awards set icon_grey = icon
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('awards', function(Blueprint $table)
        {
            $table->dropColumn('icon_grey');
        });
        Schema::table('cards', function(Blueprint $table)
        {
            $table->dropColumn('icon_grey');
        });
    }
}
