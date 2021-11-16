<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInsuranceFieldsAddMaxBenefitsCount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('insurance_fields', function (Blueprint $table) {
            $table->tinyInteger('has_multiple_benefits')->nullable();
        });

        Schema::table('policy_master', function(Blueprint $table){
            $table->tinyInteger('has_multiple_benefits')->nullable();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('insurance_fields', function (Blueprint $table) {
            $table->removeColumn('has_multiple_benefits');
        });
        Schema::table('policy_master', function(Blueprint $table){
            $table->removeColumn('has_multiple_benefits');
        });
    }
}
