<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShopIdToCustomerSales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_sales', function (Blueprint $table) {
            $table->integer('shop_id')->default(200)->comment('店铺ID，字典表ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_sales', function (Blueprint $table) {
            $table->dropColumn(["shop_id"]);
        });
    }
}
