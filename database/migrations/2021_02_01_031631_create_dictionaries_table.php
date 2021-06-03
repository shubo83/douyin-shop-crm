<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Jialeo\LaravelSchemaExtend\Schema;

class CreateDictionariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dictionaries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('字典名');
            $table->string('value')->comment('字典值');
            $table->integer('sort')->unsigned()->default(1000)->comment('排序字段');
            $table->string('extend')->nullable()->comment('扩展字段');
            $table->timestamps();
            $table->softDeletes();
            $table->comment = '字典表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dictionaries');
    }
}
