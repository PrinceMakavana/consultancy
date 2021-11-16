<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSiteSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('site_settings', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('setting_title', 191);
			$table->string('setting_key', 191);
			$table->string('setting_value', 191);
			$table->enum('is_required', array('1','0'))->default('0');
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
		Schema::drop('site_settings');
	}

}
