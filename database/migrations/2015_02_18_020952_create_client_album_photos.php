<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientAlbumPhotos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('client_album_photos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('photo_path_low_res');
			$table->string('photo_path_high_res');
			$table->integer('client_album_id')->unsigned();
			$table->foreign('client_album_id')->references('id')->on('client_albums');
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
		Schema::dropIfExists('client_album_photos');
	}

}
