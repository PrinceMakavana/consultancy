<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMutualFundInvestmentHistTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mutual_fund_investment_hist', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('investement_type')->nullable()->comment('1 - sip , 0 - lump_sum');
			$table->integer('user_id')->nullable();
			$table->integer('refrence_id')->nullable()->comment('if sip then > user_sip_investment > id lump_sum then > user_lamp_investment > id');
			$table->integer('mutual_fund_user_id')->nullable();
			$table->integer('matual_fund_id')->nullable()->comment('matual_fund > id');
			$table->float('investment_amount', 10, 0)->nullable();
			$table->float('purchased_units', 10, 0)->nullable();
			$table->float('nav_on_date', 10, 0)->nullable();
			$table->date('invested_date')->nullable();
			$table->date('due_date')->nullable();
			$table->dateTime('created_at')->nullable();
			$table->text('remarks', 65535)->nullable();
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
		Schema::drop('mutual_fund_investment_hist');
	}

}
