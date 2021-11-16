<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMutualFundNavHistTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mutual_fund_nav_hist', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('mutual_fund_id')->nullable();
			$table->float('nav', 10, 0)->nullable();
			$table->date('date')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('mutual_fund_nav_hist');
	}

}
