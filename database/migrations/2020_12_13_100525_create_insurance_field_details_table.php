<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInsuranceFieldDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('insurance_field_details', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('insurance_field_id')->nullable();
			$table->string('fieldname', 50)->nullable();
			$table->string('description')->nullable();
			$table->string('type', 190)->nullable();
			$table->text('options', 65535)->nullable();
			$table->boolean('is_required')->nullable();
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
		Schema::drop('insurance_field_details');
	}

}
