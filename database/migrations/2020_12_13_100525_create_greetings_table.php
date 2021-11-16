<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGreetingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('greetings', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->text('title', 65535)->nullable();
			$table->text('body', 65535);
			$table->enum('frequency', array('yearly'))->nullable();
			$table->text('image', 16777215);
			$table->date('date')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('status');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('greetings');
	}

}
