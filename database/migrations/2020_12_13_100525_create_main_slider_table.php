<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMainSliderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('main_slider', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->text('image', 65535)->nullable();
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
		Schema::drop('main_slider');
	}

}
