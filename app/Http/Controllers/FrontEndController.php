<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\PortfolioAlbum;
use App\PortfolioAlbumPhoto;
use App\Contact;
use App\About;
use \Illuminate\Support\Facades\DB;
use Config;
use Mail;

class FrontEndController extends Controller {

	/**
	 * returns the ID and Names of all portfolio albums
	 */
	public function getAllPortfolioAlbums()
	{
		return response()->json(PortfolioAlbum::all());
	}

	/**
	 * returns all photos for portfolio album.  Must provide the id of portfolio album
	 */
	public function getPortfolioAlbumPhotos(Request $request)
	{
		$portfolio_album_id = $request->id;
		$photos = DB::table('portfolio_album_photos')->where('portfolio_album_id','=',$portfolio_album_id)->get();
		return response()->json($photos);
	}

	/**
	 * returns Contact information
	 */
	public function getContact()
	{
		return response()->json(Contact::find(1));
	}

	/**
	 * returns about information
	 */
	public function getAbout()
	{
		return response()->json(About::find(1));
	}

	public function postMessage(Request $request)
	{
		$emailContent = ['contactMessage' => $request->message,'contactMethod' => $request->contactMethod,
						 'morning' => $request->morning,'afternoon' => $request->afternoon,
						 'night' => $request->night, 'name'=>$request->name, 'phone' => $request->phone];
		Mail::send('emails.request_contact',$emailContent,function($message) use($request)
		{
			$message->from($request->email);
			$message->to(Config::get('constants.site.OWNEREMAIL'),Config::get('constants.site.OWNERNAME'));
			$message->subject('Request Contact');

		});

	}

}
