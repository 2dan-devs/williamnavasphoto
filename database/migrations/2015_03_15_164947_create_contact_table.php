<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contact', function(Blueprint $table)
		{
			// Table columns.
			$table->increments('id'); // Auto incrementing Primary Key.
			$table->string('title',25);
			// Address fields
			$table->string('address',100);
			$table->string('city',50);
			$table->string('state',2);
			$table->string('zip', 10);

			//contact info
			$table->string('email', 100);
			$table->string('phone', 16);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('contact');
	}

}
