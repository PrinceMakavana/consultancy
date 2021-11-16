<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInsuranceSubCategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('insurance_sub_category', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('category_id')->nullable();
			$table->string('name', 50)->nullable();
			$table->boolean('status')->nullable()->default(1)->comment('1=\'active\' , 0=\'deactive\'');
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
		Schema::drop('insurance_sub_category');
	}

}
