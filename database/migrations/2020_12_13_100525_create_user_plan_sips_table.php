<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserPlanSipsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_plan_sips', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('user_plan_id')->nullable();
			$table->integer('mutual_fund_user_id')->nullable();
			$table->float('sip_amount', 10, 0)->nullable();
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
		Schema::drop('user_plan_sips');
	}

}
