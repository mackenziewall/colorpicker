<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRgbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //create rgb table
        Schema::create('rgb', function($table)
        {
            $table->increments('id');
            $table->integer('block');
            $table->integer('r');
            $table->integer('g');
            $table->integer('b');
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
        Schema::drop('rgb');
    }
}
