<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Jialeo\LaravelSchemaExtend\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->integer('admin_user_id')->default(0)->comment('管理员用户ID');
            $table->tinyInteger('status')->default(1)->comment('状态1=公海2=跟进中3=已跟进');
            $table->integer('platform_type_id')->default(1)->comment('平台类型字典ID');
            $table->string('nickname')->default('')->comment('昵称');
            $table->string('platform_user_id')->default('')->comment('平台用户ID');
            $table->string('contact_person')->nullable()->comment('联系人');
            $table->string('mobile')->nullable()->comment('手机号');
            $table->string('wechat_account')->nullable()->comment('微信号');
            $table->decimal('fans_number')->default(0)->comment('粉丝数量(万)');
            $table->decimal('shop_score')->default(0)->comment('橱窗评分');
            $table->decimal('shop_sales')->default(0)->comment('橱窗销量(万)');
            $table->integer('shop_category_id')->default(0)->comment('橱窗类目字典ID');
            $table->timestamps();
            $table->softDeletes();
            $table->comment = '客户表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
