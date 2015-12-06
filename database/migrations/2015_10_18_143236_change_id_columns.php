<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeIdColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('block', function($table)
        {
            $table->renameColumn('swatch', 'swatch_id');
        });
        Schema::table('hex', function($table)
        {
            $table->renameColumn('block', 'block_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //

        Schema::table('block', function($table)
        {
            $table->renameColumn('swatch_id', 'swatch');
        });
        Schema::table('hex', function($table)
        {
            $table->renameColumn('block_id', 'block');
        });
    }
}
