<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLifeInsuranceUlipsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('life_insurance_ulips', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('user_id')->nullable();
			$table->enum('investment_through', array('patel_consultancy','other'))->nullable();
			$table->string('status', 190)->nullable()->comment('open, close, complete');
			$table->bigInteger('company_id')->nullable();
			$table->bigInteger('policy_no')->nullable();
			$table->string('plan_name', 191)->nullable();
			$table->decimal('nav', 10)->nullable();
			$table->date('issue_date')->nullable();
			$table->date('maturity_date')->nullable();
			$table->float('maturity_amount', 10, 0)->nullable();
			$table->float('sum_assured', 10, 0)->nullable();
			$table->bigInteger('premium_amount')->nullable();
			$table->bigInteger('permium_paying_term')->nullable()->comment('in year');
			$table->date('last_premium_date')->nullable();
			$table->text('premium_mode', 65535)->nullable()->comment('0-Fortnight , 1-monthly , 2-quatarly');
			$table->integer('policy_term')->nullable()->comment('in year');
			$table->date('is_trashed')->nullable();
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
		Schema::drop('life_insurance_ulips');
	}

}
