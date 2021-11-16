<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMutualFundTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mutual_fund', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name', 55)->nullable();
			$table->integer('company_id')->nullable();
			$table->enum('direct_or_regular', array('direct','regular'))->nullable();
			$table->enum('main_type', array('equity','hybrid','debt','solution_oriented','other'))->nullable();
			$table->integer('type_id')->nullable()->comment('matual_fund_type > id');
			$table->decimal('nav', 10)->nullable();
			$table->dateTime('nav_updated_at')->nullable();
			$table->decimal('min_sip_amount', 10)->nullable();
			$table->float('fund_size', 10, 0)->nullable()->comment('total fund amount by amc');
			$table->timestamps();
			$table->boolean('status')->nullable()->default(1)->comment('1=\'active\' , 0=\'deactive\'');
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
		Schema::drop('mutual_fund');
	}

}
