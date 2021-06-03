<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommissionToSendSampleProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('send_sample_products', function (Blueprint $table) {
            $table->integer('commission')->comment('给达人的产品佣金，单位%，默认25%');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('send_sample_products', function (Blueprint $table) {
            $table->dropColumn(["commission"]);
        });
    }
}
