<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyValueProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_value_product', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('property_value_id');
            $table->unsignedInteger('product_id');
            $table->timestamps();

            $table->foreign('property_value_id')->references('id')->on('property_values');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_value_product');
    }
}
