<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientPrintsSelections extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('client_prints_selections', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('print_order_id')->unsigned();
			$table->foreign('print_order_id')->references('id')->on('orders');
			$table->integer('client_album_photo_id')->unsigned();
			$table->foreign('client_album_photo_id')->references('id')->on('client_album_photos');
			$table->integer('format_id')->unsigned();
			$table->integer('quantity');
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
		//
		Schema::dropIfExists('client_prints_selections');
	}

}
