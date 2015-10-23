<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientAlbums extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('client_albums', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('album_name',30);
			$table->string('album_cover_photo');
			$table->integer('client_id')->unsigned();
			$table->foreign('client_id')->references('id')->on('clients');
			//The maximum amount of photos client is allowed to choose for album
			$table->integer('photo_selection_max');
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
		Schema::dropIfExists('client_albums');
	}

}
