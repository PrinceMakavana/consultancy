<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUlipActualValueRequestTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ulip_actual_value_request', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('policy_id')->nullable();
			$table->integer('request_by')->nullable();
			$table->string('actual_value', 190)->nullable();
			$table->string('actual_nav', 190)->nullable();
			$table->string('status', 190)->nullable()->comment('requested, done, cancelled');
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ulip_actual_value_request');
	}

}
