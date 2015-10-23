<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientAlbumSelections extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('client_album_selections', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('album_order_id')->unsigned();
			$table->foreign('album_order_id')->references('id')->on('orders');
			$table->integer('client_album_photo_id')->unsigned();
			$table->foreign('client_album_photo_id')->references('id')->on('client_album_photos');
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
		Schema::dropIfExists('client_album_selections');
	}

}
