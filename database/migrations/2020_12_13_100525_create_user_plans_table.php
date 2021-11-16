<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserPlansTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_plans', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('user_id')->nullable();
			$table->integer('type')->nullable();
			$table->float('target_amount', 10, 0)->nullable();
			$table->float('return_rate', 4)->nullable()->default(12.00);
			$table->dateTime('start_at')->nullable();
			$table->dateTime('end_at')->nullable();
			$table->string('document', 100)->nullable();
			$table->boolean('status')->nullable()->default(1)->comment('1=\'active\' , 0=\'deactive\'');
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
		Schema::drop('user_plans');
	}

}
