<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewInsuranceStatusHist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurance_status_hist', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('policy_id')->nullable();
            $table->string('tbl_type', 191)->nullable();
            $table->string('status', 191)->nullable();
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('insurance_status_hist');
    }
}
