<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePremiumMasterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('premium_master', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->bigInteger('policy_id')->nullable();
			$table->string('tbl_key', 50);
			$table->bigInteger('amount')->nullable();
			$table->date('premium_date')->nullable();
			$table->date('paid_at')->nullable();
			$table->timestamps();
			$table->dateTime('is_trashed')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('premium_master');
	}

}
