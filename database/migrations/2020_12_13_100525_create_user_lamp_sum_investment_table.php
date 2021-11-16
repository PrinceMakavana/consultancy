<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserLampSumInvestmentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_lamp_sum_investment', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->enum('investment_through', array('patel_consultancy','other'))->nullable();
			$table->integer('user_id')->nullable();
			$table->string('folio_no', 191)->nullable();
			$table->integer('mutual_fund_user_id')->nullable()->comment('mutual_fund_user > id');
			$table->integer('matual_fund_id')->nullable();
			$table->float('invested_amount', 10, 0)->nullable();
			$table->float('nav_on_date', 10, 0)->nullable();
			$table->dateTime('invested_at')->nullable();
			$table->float('units', 10, 0)->nullable();
			$table->dateTime('created_at')->nullable();
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
		Schema::drop('user_lamp_sum_investment');
	}

}
