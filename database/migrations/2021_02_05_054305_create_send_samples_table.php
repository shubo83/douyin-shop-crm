<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Jialeo\LaravelSchemaExtend\Schema;

class CreateSendSamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('send_samples', function (Blueprint $table) {
            $table->id();
            $table->integer('admin_user_id')->default(0)->comment('管理员用户ID');
            $table->integer('customer_id')->default(0)->comment('达人ID');
            $table->integer('customer_address_id')->default(0)->comment('达人收货地址ID');
            $table->tinyInteger('apply_status')->default(0)->comment('审核状态1=审核中2=审核拒绝3=已发货4=已签收');
            $table->string('reject_reason')->nullable()->comment('拒绝原因');
            $table->timestamps();
            $table->softDeletes();
            $table->comment = '寄样表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('send_samples');
    }
}
