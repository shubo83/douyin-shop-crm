<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Jialeo\LaravelSchemaExtend\Schema;

class CreateCustomerShopSalesHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_shop_sales_histories', function (Blueprint $table) {
            $table->id();
            $table->integer("customer_id")->comment("客户ID");
            $table->decimal("shop_sales")->comment("店铺销量");
            $table->timestamps();
            $table->comment = "客户店铺销量历史";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_shop_sales_histories');
    }
}
