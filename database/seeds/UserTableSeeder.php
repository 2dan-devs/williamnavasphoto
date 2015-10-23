<?php 
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();
        $password = bcrypt('wnp2015');
        User::create([	'email'	=>'admin@wnp.com',
        			   	'password'	=> $password,
        			   	'is_admin'	=>1,
        			   	'is_active'	=>1]);

        $password = bcrypt('simon');
        User::create([	'email'	=>'admin1@wnp.com',
        			   	'password'	=> $password,
        			   	'is_admin'	=>1,
        			   	'is_active'	=>1]);

    }

}