<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CombiningBlocksHex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('block', function ($table) {
            $table->string('value');
        });
        //create hex table

        Schema::drop('hex');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //dropColumn
        Schema::table('block', function ($table) {
            $table->dropColumn('value');
        });
        Schema::create('hex', function($table)
        {
            $table->increments('id');
            $table->integer('block_id');
            $table->string('value');
            $table->timestamps();
        });
    }
}
