<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePolicyDocumentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('policy_documents', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('policy_id')->nullable();
			$table->string('tbl_key', 190)->nullable();
			$table->string('title', 190)->nullable();
			$table->string('document', 190)->nullable();
			$table->string('document_name', 190)->nullable();
			$table->text('notes', 65535)->nullable();
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
		Schema::drop('policy_documents');
	}

}
