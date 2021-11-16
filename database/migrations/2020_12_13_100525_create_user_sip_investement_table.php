<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserSipInvestementTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_sip_investement', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->enum('investment_through', array('patel_consultancy','other'))->nullable();
			$table->integer('user_id');
			$table->string('folio_no', 191)->nullable();
			$table->integer('mutual_fund_user_id')->nullable()->comment('mutual_fund_user > id');
			$table->integer('matual_fund_id')->nullable();
			$table->float('sip_amount', 10, 0)->nullable();
			$table->float('invested_amount', 10, 0)->nullable();
			$table->enum('time_period', array('weekly','fortnightly','monthly','quarterly'))->nullable();
			$table->string('investment_for', 191)->nullable();
			$table->float('target_amount', 10, 0)->nullable();
			$table->float('units', 10, 0)->nullable();
			$table->dateTime('start_date')->nullable();
			$table->dateTime('end_date')->nullable();
			$table->softDeletes();
			$table->dateTime('created_at');
			$table->boolean('status')->comment('1=\'active\' , 0=\'deactive\'');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_sip_investement');
	}

}
