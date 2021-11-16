<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblInsuranceAddTerminateReason extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('life_insurance_traditionals', function (Blueprint $table) {
            $table->text('terminate_reason')->nullable();
            $table->dateTime('terminate_at')->nullable();
        });

        Schema::table('life_insurance_ulips', function (Blueprint $table) {
            $table->text('terminate_reason')->nullable();
            $table->dateTime('terminate_at')->nullable();
        });

        Schema::table('policy_master', function (Blueprint $table) {
            $table->text('terminate_reason')->nullable();
            $table->dateTime('terminate_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('life_insurance_traditionals', function (Blueprint $table) {
            //
        });
    }
}
