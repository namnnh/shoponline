<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('categories', function (Blueprint $table) {
                $table->increments('id')->unsigned();
                $table->string('name',255);
                $table->string('image',64)->nullable();
                $table->integer('sort_order')->default(0);
                $table->integer('parent_id')->nullable()->unsigned();
                $table->timestamps();
         });

         Schema::table('categories', function(Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::dropIfExists('categories');
    }
}
