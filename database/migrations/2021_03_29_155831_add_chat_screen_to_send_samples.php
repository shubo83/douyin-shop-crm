<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChatScreenToSendSamples extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('send_samples', function (Blueprint $table) {
            $table->string('chat_screen')->nullable()->comment('聊天截图');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('send_samples', function (Blueprint $table) {
            $table->dropColumn(["chat_screen"]);
        });
    }
}
