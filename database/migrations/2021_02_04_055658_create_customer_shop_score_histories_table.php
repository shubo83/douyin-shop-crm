<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Jialeo\LaravelSchemaExtend\Schema;

class CreateCustomerShopScoreHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_shop_score_histories', function (Blueprint $table) {
            $table->id();
            $table->integer("customer_id")->comment("客户ID");
            $table->decimal("shop_score")->comment("店铺评分");
            $table->timestamps();
            $table->comment = "客户店铺评分历史";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_shop_score_histories');
    }
}
