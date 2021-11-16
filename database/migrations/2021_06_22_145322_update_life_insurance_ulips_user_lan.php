<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateLifeInsuranceUlipsUserLan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('life_insurance_ulips', function (Blueprint $table) {
            $table->integer('user_plan_id')->nullable();
            $table->foreign('user_plan_id', 'life_insurance_ulips_ibfk_1')->references('id')->on('user_plans')->onUpdate('SET NULL')->onDelete('SET NULL');
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
            $table->dropForeign('life_insurance_ulips_ibfk_1');
            $table->removeColumn('user_plan_id');
        });
    }
}
