<?php 
use App\About;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AboutTableSeeder extends Seeder {

    public function run()
    {
        DB::table('about')->delete();

        About::create(['title'	=>'Photo Site',
        			   'body'	=>'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quis alias rerum obcaecati itaque suscipit sequi, ipsum illum provident atque cupiditate explicabo nisi ullam veniam saepe cum cumque nam repudiandae velit? &#10 Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non iusto sed in quia blanditiis vitae fuga perspiciatis quae. Libero et adipisci voluptatem mollitia nam ipsa, voluptatum voluptate repudiandae quia, nisi.']);

    }

}