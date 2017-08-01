<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('option_value', function (Blueprint $table) {
                $table->increments('id')->unsigned();
                $table->integer('option_id')->unsigned();
                $table->string('name',128);
                $table->integer('sort_order');

                $table->foreign('option_id')->references('id')->on('option')
                ->onUpdate('cascade')->onDelete('cascade');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('option_value');
        //
    }
}
