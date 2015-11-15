<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortfolioAlbumPhotos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('portfolio_album_photos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('photo_path');
			$table->integer('portfolio_album_id')->unsigned();
			$table->foreign('portfolio_album_id')->references('id')->on('portfolio_albums');
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
		Schema::dropIfExists('portfolio_album_photos');
	}

}
