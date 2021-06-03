<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Jialeo\LaravelSchemaExtend\Schema;

class CreateCustomerFansNumberHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_fans_number_histories', function (Blueprint $table) {
            $table->id();
            $table->integer("customer_id")->comment("客户ID");
            $table->decimal("fans_number")->comment("粉丝量");
            $table->timestamps();
            $table->comment = "客户店铺粉丝量历史";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_fans_number_histories');
    }
}
