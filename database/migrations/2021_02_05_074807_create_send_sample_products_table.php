<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Jialeo\LaravelSchemaExtend\Schema;

class CreateSendSampleProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('send_sample_products', function (Blueprint $table) {
            $table->id();
            $table->integer('send_sample_id')->default(0)->comment('寄样ID');
            $table->integer('product_id')->default(0)->comment('产品ID');
            $table->integer('quantity')->default(0)->comment('数量');
            $table->string('remark')->nullable()->comment('备注');
            $table->string('courier_number')->nullable()->comment('快递单号');
            $table->datetime('receipted_at')->nullable()->comment('签收日期');
            $table->timestamps();
            $table->softDeletes();
            $table->comment = '寄样产品表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('send_sample_products');
    }
}
