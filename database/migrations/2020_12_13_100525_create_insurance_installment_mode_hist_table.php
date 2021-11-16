<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInsuranceInstallmentModeHistTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('insurance_installment_mode_hist', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('policy_id')->nullable();
			$table->string('tbl_type', 190)->nullable();
			$table->date('from_date')->nullable();
			$table->string('premium_mode', 190)->nullable();
			$table->string('premium_amount', 190)->nullable();
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
		Schema::drop('insurance_installment_mode_hist');
	}

}
