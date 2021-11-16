<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePolicySurrendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('policy_surrenders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('policy_id')->nullable();
            $table->string('tbl_key', 190)->nullable();
            $table->text('notes')->nullable();
            $table->float('amount')->nullable();
            $table->dateTime('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('policy_surrenders');
    }
}
