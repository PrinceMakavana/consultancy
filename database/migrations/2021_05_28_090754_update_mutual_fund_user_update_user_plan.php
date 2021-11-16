<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMutualFundUserUpdateUserPlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mutual_fund_user', function (Blueprint $table) {
            
            DB::statement('ALTER TABLE `mutual_fund_user` CHANGE `user_plan_id` `user_plan_id` INT NULL DEFAULT NULL;');
            $table->foreign('user_plan_id', 'mutual_fund_user_ibfk_1')->references('id')->on('user_plans')->onUpdate('SET NULL')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mutual_fund_user', function (Blueprint $table) {
            $table->dropForeign('mutual_fund_user_ibfk_1');
        });
    }
}
