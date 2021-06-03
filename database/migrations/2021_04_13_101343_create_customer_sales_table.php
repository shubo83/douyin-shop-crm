<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Jialeo\LaravelSchemaExtend\Schema;

class CreateCustomerSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_sales', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->default(0)->comment('达人ID');
            $table->integer('year')->default(0)->comment('年');
            $table->integer('month')->default(0)->comment('月');
            $table->unsignedDecimal('sales',18)->default(0)->comment('销售额');
            $table->timestamps();
            $table->comment = '达人销售额表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_sales');
    }
}
