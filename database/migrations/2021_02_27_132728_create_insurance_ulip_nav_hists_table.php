<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsuranceUlipNavHistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurance_ulip_nav_hists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('life_insurance_ulip_id')->nullable();
            $table->decimal('nav')->nullable();
            $table->bigInteger('changed_by')->nullable();
			$table->dateTime('changed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insurance_ulip_nav_hists');
    }
}
