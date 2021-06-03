<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->default(0)->comment('达人ID');
            $table->string('consignee_name')->nullable()->comment('收货人姓名');
            $table->string('consignee_mobile')->nullable()->comment('收货人手机号');
            $table->string('consignee_address')->nullable()->comment('收货人详细地址');
            $table->timestamps();
            $table->softDeletes();
            $table->comment = '达人收货地址表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_addresses');
    }
}
