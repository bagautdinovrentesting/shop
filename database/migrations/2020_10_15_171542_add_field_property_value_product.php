<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldPropertyValueProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_value_product', function (Blueprint $table) {
            $table->unsignedInteger('property_id')->nullable();

            $table->foreign('property_id')->references('id')->on('properties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_value_product', function (Blueprint $table) {
            $table->dropForeign('property_value_product_property_id_foreign');
            $table->dropColumn('property_id');
        });
    }
}
