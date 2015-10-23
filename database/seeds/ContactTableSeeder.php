<?php 

use App\Contact;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ContactTableSeeder extends Seeder {

    public function run()
    {
        DB::table('contact')->delete();

        Contact::create([
			'title'	 =>'Animal Shelter',
			'address'=>'111 Someplace Street',
	        'city'	 =>'Heaven',
	        'state'	 =>'NJ',
	        'zip'	 =>'10000',
			'email'=>'cats@animalshelter.com',
			'phone'=>'777-777-1111'
		]);

    }

}