<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGreetingsHistTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('greetings_hist', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->bigInteger('user_id')->nullable();
			$table->string('type', 50)->nullable();
			$table->date('date')->nullable();
			$table->text('details', 65535)->nullable();
			$table->text('device_token', 65535)->nullable();
			$table->dateTime('send_at')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('greetings_hist');
	}

}
