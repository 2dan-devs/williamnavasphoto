<?php 
use App\PhotoFormat;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PhotoFormatTableSeeder extends Seeder {

    public function run()
    {
        DB::table('photo_format')->delete();

        PhotoFormat::create(['format' 	=> '4 x 6']);
        PhotoFormat::create	(['format'	=> '5 x 7']);
        PhotoFormat::create	(['format'	=> '8 x 10']);
        
    }

}