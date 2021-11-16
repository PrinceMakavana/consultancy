<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInsuranceFieldsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('insurance_fields', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name', 50)->nullable();
			$table->boolean('status')->nullable()->default(1)->comment('1=\'active\' , 0=\'deactive\'');
			$table->timestamps();
			$table->dateTime('is_trashed')->nullable();
			$table->string('benefit_name', 190)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('insurance_fields');
	}

}
