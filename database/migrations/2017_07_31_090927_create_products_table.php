<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
                $table->increments('id')->unsigned();
                $table->string('name',255);
                $table->mediumText('description');
                $table->string('meta_description');
                $table->string('meta_keyword');
                $table->mediumText('tag');
                $table->string('image',64);
                $table->string('model',64)->nullable();
                $table->integer('quantity')->default(0);
                $table->decimal('price',15,4);
                $table->integer('sort_order')->default(0);
                $table->string('status',20);
                $table->integer('viewed')->default(0);
                $table->integer('minimum')->default(0);
                $table->integer('points')->default(0);
                $table->dateTime('date_available');
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
        Schema::dropIfExists('products');
    }
}
