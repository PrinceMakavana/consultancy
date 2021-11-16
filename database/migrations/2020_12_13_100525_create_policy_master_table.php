<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePolicyMasterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('policy_master', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->bigInteger('user_id')->nullable();
			$table->bigInteger('policy_no')->nullable();
			$table->string('plan_name', 191)->nullable();
			$table->string('investment_through', 190)->nullable();
			$table->date('issue_date')->nullable();
			$table->bigInteger('company_id')->nullable();
			$table->bigInteger('category_id')->nullable();
			$table->bigInteger('sub_category_id')->nullable();
			$table->float('sum_assured', 10, 0)->nullable();
			$table->bigInteger('premium_amount')->nullable();
			$table->bigInteger('permium_paying_term')->nullable()->comment('in year');
			$table->date('last_premium_date')->nullable();
			$table->text('premium_mode', 65535)->nullable()->comment('0-Fortnight , 1-monthly , 2-quatarly');
			$table->integer('policy_term')->nullable()->comment('in year');
			$table->text('other_fields')->nullable();
			$table->date('is_trashed')->nullable();
			$table->timestamps();
			$table->integer('insurance_field_id');
			$table->boolean('is_policy_detail_done');
			$table->string('has_death_benefits', 190)->nullable();
			$table->string('status', 190)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('policy_master');
	}

}
