<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMutualFundUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mutual_fund_user', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->enum('investment_through', array('patel_consultancy','other'))->nullable()->comment('patel_consultancy, other');
			$table->bigInteger('user_plan_id')->nullable();
			$table->integer('user_id')->nullable();
			$table->string('folio_no', 191)->nullable();
			$table->integer('matual_fund_id')->nullable();
			$table->decimal('sip_amount', 10)->nullable();
			$table->float('total_units', 10, 0)->nullable()->comment('on change rate in matule fund, change unit');
			$table->float('invested_amount', 10, 0)->nullable();
			$table->date('start_date')->nullable();
			$table->float('absolute_return', 10, 0)->nullable();
			$table->timestamps();
			$table->float('annual_return', 10, 0)->nullable();
			$table->integer('status')->nullable();
			$table->dateTime('is_trashed')->nullable();
			$table->date('end_date')->nullable();
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
		Schema::drop('mutual_fund_user');
	}

}
