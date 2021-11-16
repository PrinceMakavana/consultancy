<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePolicyBenefitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('policy_benefits', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->bigInteger('policy_id')->nullable();
			$table->string('tbl_key', 50);
			$table->string('benefit_type', 20);
			$table->text('notes', 65535)->nullable();
			$table->float('amount', 10, 0)->nullable();
			$table->dateTime('received_at')->nullable();
			$table->date('date')->nullable();
			$table->integer('is_done')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('policy_benefits');
	}

}
