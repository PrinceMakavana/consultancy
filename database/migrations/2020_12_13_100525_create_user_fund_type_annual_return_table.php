<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserFundTypeAnnualReturnTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_fund_type_annual_return', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->string('type', 25)->nullable();
			$table->bigInteger('fund_type_id')->nullable();
			$table->bigInteger('user_id')->nullable();
			$table->float('annual_return', 10, 0)->nullable();
			$table->dateTime('annual_cached_at')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_fund_type_annual_return');
	}

}
