<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWithdrawUserFundTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('withdraw_user_fund', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->bigInteger('user_id')->nullable();
			$table->enum('withdraw_type', array('by_units','by_amount'))->nullable();
			$table->bigInteger('user_fund_id')->nullable();
			$table->bigInteger('mutual_fund_id')->nullable();
			$table->float('amount', 10, 0)->nullable();
			$table->float('units', 10, 0)->nullable();
			$table->float('nav_on_date', 10, 0)->nullable();
			$table->date('withdraw_date')->nullable();
			$table->text('remark', 65535)->nullable();
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
		Schema::drop('withdraw_user_fund');
	}

}
