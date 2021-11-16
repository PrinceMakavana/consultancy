<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateLifeInsuranceUlipAddUnits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('life_insurance_ulips', function (Blueprint $table) {
            $table->float('units')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('life_insurance_ulips', function (Blueprint $table) {
            $table->removeColumn('units');
        });
    }
}
