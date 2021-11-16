<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewUlipActualValueRequestStatusHist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ulip_actual_value_request_status_hist', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ulip_actual_value_request_id')->nullable();
            $table->string('status', 190)->nullable();
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
        Schema::dropIfExists('ulip_actual_value_request_status_hist');
    }
}
