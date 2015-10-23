<?php 

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Database\Seeds\ContactTableSeeder;
use Database\Seeds\AboutTableSeeder;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
		$this->call('ContactTableSeeder');
		$this->call('AboutTableSeeder');
		$this->call('PhotoFormatTableSeeder');
		$this->call('UserTableSeeder');
	}

}
