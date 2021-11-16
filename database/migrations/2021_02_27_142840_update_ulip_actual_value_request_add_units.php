<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUlipActualValueRequestAddUnits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ulip_actual_value_request', function (Blueprint $table) {
            $table->float('actual_units')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ulip_actual_value_request', function (Blueprint $table) {
            $table->removeColumn('actual_units');
        });
    }
}
