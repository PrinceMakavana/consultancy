<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewNotificationHist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_hist', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('policy_type', 190)->nullable();
            $table->integer('policy_id')->nullable();
            $table->date('premium_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_hist');
    }
}
