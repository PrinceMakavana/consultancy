<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserPlanLifeInsuranceTraditionals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('life_insurance_traditionals', function (Blueprint $table) {
            $table->integer('user_plan_id')->nullable();
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
            $table->removeColumn('user_plan_id');
        });
    }
}
