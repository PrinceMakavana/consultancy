<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateLifeInsuranceTraditionalsUserPlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('life_insurance_traditionals', function (Blueprint $table) {
            $table->foreign('user_plan_id', 'life_insurance_traditionals_ibfk_1')->references('id')->on('user_plans')->onUpdate('SET NULL')->onDelete('SET NULL');
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
            $table->dropForeign('life_insurance_traditionals_ibfk_1');
        });
    }
}
