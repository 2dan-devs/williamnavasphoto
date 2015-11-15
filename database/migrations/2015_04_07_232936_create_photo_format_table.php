<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotoFormatTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('photo_format', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('format',10);
		});
		Schema::table('client_prints_selections',function($table)
		{
			$table->foreign('format_id')->references('id')->on('photo_format');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('client_prints_selections',function($table)
		{
			$table->dropForeign('client_prints_selections_format_id_foreign');
		});
		
		Schema::dropIfExists('photo_format');
	}

}
