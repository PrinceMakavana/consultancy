<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserRegisterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_register', function(Blueprint $table)
		{
			$table->integer('user_id', true);
			$table->string('access_token', 80)->nullable();
			$table->string('user_name', 191);
			$table->text('password', 65535);
			$table->text('user_email', 65535);
			$table->boolean('email_varify')->nullable()->default(0)->comment('0 = no, 1 - yes');
			$table->string('varification_code', 191)->nullable();
			$table->string('mobile_no', 15);
			$table->string('pan_no', 12)->nullable();
			$table->text('profile_picture', 65535)->nullable();
			$table->text('pan_card_img', 65535)->nullable();
			$table->text('address', 65535);
			$table->boolean('request_status')->nullable()->comment('default null, 0 - declined, 1 - approved');
			$table->enum('status', array('0','1'))->comment('1=\'active\' , 0=\'deactive\'');
			$table->dateTime('create_date');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_register');
	}

}
