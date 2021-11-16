<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('name', 191)->nullable();
			$table->string('email', 191)->nullable()->unique();
			$table->string('mobile_no', 191)->nullable();
			$table->string('profile', 191)->nullable();
			$table->string('api_token', 191)->nullable();
			$table->boolean('is_reported')->nullable()->default(0)->comment('1 - reported, 0 - not reported');
			$table->string('reason', 191)->nullable();
			$table->string('password', 191);
			$table->boolean('status')->nullable()->comment('1=\'active\' , 0=\'deactive\'');
			$table->string('remember_token', 100)->nullable();
			$table->string('pan_no', 100)->nullable();
			$table->string('pan_card_img', 100)->nullable();
			$table->dateTime('email_verified_at')->nullable();
			$table->timestamps();
			$table->date('birthdate')->nullable();
			$table->text('device_token', 65535)->nullable();
			$table->integer('greetings_notification')->nullable();
			$table->integer('doc_limit')->default(5);
			$table->string('user_docs', 500);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
