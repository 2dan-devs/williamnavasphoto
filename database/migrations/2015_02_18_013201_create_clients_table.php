<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('clients', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('profile_photo')->nullable();
			$table->string('first_name',25);
			$table->string('last_name',25);
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
			$table->string('email',100);
			$table->string('phone_1',12);
			$table->string('phone_2',12)->nullable();
			$table->string('address_1',100);
			$table->string('address_2',100);
			$table->string('city',30);
			$table->string('state',2);
			$table->string('zip',10);
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::dropIfExists('clients');
	}

}
