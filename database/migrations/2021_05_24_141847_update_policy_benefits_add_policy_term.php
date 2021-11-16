<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePolicyBenefitsAddPolicyTerm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('policy_benefits', function (Blueprint $table) {
            $table->string('policy_year', 190)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('policy_benefits', function (Blueprint $table) {
            $table->removeColumn('policy_year');
        });
    }
}
