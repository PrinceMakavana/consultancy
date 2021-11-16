<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMutualFundTypeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mutual_fund_type', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->enum('main_type', array('equity','hybrid','debt','solution_oriented','other'))->nullable();
			$table->string('name', 50)->nullable();
			$table->text('description', 65535)->nullable();
			$table->dateTime('created_at')->nullable();
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
		Schema::drop('mutual_fund_type');
	}

}
