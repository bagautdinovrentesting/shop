<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('customer_name');
            $table->string('customer_surname')->nullable();
            $table->string('customer_phone');
            $table->string('customer_email');
            $table->text('customer_address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('customer_name');
            $table->dropColumn('customer_surname');
            $table->dropColumn('customer_phone');
            $table->dropColumn('customer_email');
            $table->dropColumn('customer_address');
        });
    }
}
