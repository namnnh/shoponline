<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductOptionValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_option_value', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('product_option_id')->unsigned();
            $table->integer('option_value_id')->unsigned();
            $table->integer('quantity');
            $table->decimal('price',15,4);
            $table->string('price_prefix',1);
            $table->integer('points');
            $table->string('points_prefix',1);
            $table->decimal('weight',15,8);
            $table->string('weight_prefix');


            $table->foreign('product_option_id')->references('id')->on('product_option')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('option_value_id')->references('id')->on('option_value')
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
        Schema::dropIfExists('product_option_value');
    }
}
