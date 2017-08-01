<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name',64);
            $table->integer('attribute_group_id')->unsigned();
            $table->integer('sort_order');

            $table->foreign('attribute_group_id')->references('id')->on('attribute_group')
                ->onUpdate('cascade')->onDelete('cascade');
         })
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attribute');
    }
}
