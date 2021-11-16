<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUlipUnitHist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('life_insurance_ulip_unit_hist', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('policy_id')->nullable();
            $table->integer('premium_id')->nullable();
            $table->string('tbl_key', 190)->nullable();
            $table->string('type', 190)->nullable()->comment('add|withdraw');
            $table->float('nav')->nullable();
            $table->float('units')->nullable();
            $table->float('amount')->nullable();
            $table->date('added_at')->nullable();
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
        Schema::dropIfExists('life_insurance_ulip_unit_hist');
    }
}
