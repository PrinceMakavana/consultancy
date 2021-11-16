<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateLifeInsuranceTraditionalsPolicyNo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('life_insurance_traditionals', function (Blueprint $table) {
            DB::statement('ALTER TABLE `life_insurance_traditionals` CHANGE `policy_no` `policy_no` VARCHAR(190) NULL DEFAULT NULL;');
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
