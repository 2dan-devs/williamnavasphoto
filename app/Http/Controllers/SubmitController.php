<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ClientAlbumPhoto;
use App\PortfolioAlbumPhoto;
use Intervention\Image\ImageManagerStatic as Image;
use App\ClientAlbum;
use App\Order;
use App\ClientAlbumSelection;
use Mail;
use App\Client;
use Config;
use App\ClientPrintsSelection;
use Session;
use Input;
use Illuminate\Support\Facades\DB;
use App\helpers\FlashMessage;

class SubmitController extends Controller {

	public function albumPhotos(Request $request)
	{
		$images = $request->files->get('images');

		$client_album_id = $request->input("client_album_id");

		foreach($images as $image)
		{
			$filename = time()."-". $image->getClientOriginalName();
			$lowPath = public_path('assets/images/client_albums/'.$client_album_id.'/low_res/'.$filename);
			$highPath = public_path('assets/images/client_albums/'.$client_album_id.'/high_res/'.$filename);
			
			//open image file
			$photo = Image::make($image->getRealPath());

			$photo->save($highPath,100);  //save high resolution photo
			$photo->resize(null, 600, 
					function ($constraint) 
					{
						$constraint->aspectRatio();
						$constraint->upsize();
					})->save($lowPath,80);  //save low resolution photo
			$albumPhoto = new ClientAlbumPhoto();
			$albumPhoto->photo_path_low_res = 'assets/images/client_albums/'.$client_album_id.'/low_res/'.$filename;
			$albumPhoto->photo_path_high_res = 'assets/images/client_albums/'.$client_album_id.'/high_res/'.$filename;
			$albumPhoto->client_album_id = $client_album_id;
			$albumPhoto->save();
		}
	}

	public function portfolioPhotos(Request $request)
	{
		$images = $request->files->get('image');
		$portfolio_album_id = $request->input("portfolio_album_id");

		foreach($images as $image)
		{
			$filename = time()."-". $image->getClientOriginalName();
			$path = public_path('assets/images/portfolio_albums/'.$portfolio_album_id.'/'.$filename);
			//open image file
			$photo = Image::make($image->getRealPath());

			$photo->save($path,100);  //save high resolution photo
			
			$portfolioPhoto = new PortfolioAlbumPhoto();
			$portfolioPhoto->photo_path = 'assets/images/portfolio_albums/'.$portfolio_album_id.'/'.$filename;
			$portfolioPhoto->portfolio_album_id = $portfolio_album_id;
			$portfolioPhoto->save();
		}
	}

	public function albumPurchase(Request $request)
	{
		$photos = $request->photos;
		$albumID = $request->album_id;
		$album = ClientAlbum::find($albumID);
		$client = $album->client;
		$clientName = $client->first_name." ". $client->last_name;
		
		//create album order in database
		$order = new Order();
		$order->client_album_id = $albumID;
		$order->client_id = $client->id;
		$order->status = "In Progress";
		$order->type = "Album Order";
		$order->save();

		//save all photos in album purchase to database
		foreach ($photos as $photo)
		{
			$selectedPhoto = new ClientAlbumSelection();
			$selectedPhoto->album_order_id = $order->id;
			$selectedPhoto->client_album_photo_id = $photo["photo_id"];
			$selectedPhoto->save();
		}

		//send email confirmation to customer and admin
		Mail::send('emails.order_confirmation',[],function($message) use($client,$clientName)
		{
			$message->to($client->email,$clientName)->subject('Album Order Received');
		});

		Mail::send('emails.admin_order_notification',[],function($message)
		{
			$message->to(Config::get('constants.site.OWNEREMAIL'),Config::get('constants.site.OWNERNAME'))->subject('Album Order Received');
		});
		Session::flash('message', FlashMessage::DisplayAlert('Your album purchase was successful!', 'success'));
	}//end album purchase

	public function editAlbumPurchase(Request $request)
	{
		$photos = $request->photos;
		$user = \Auth::user();
		$client = $user->client;
		$clientName = $client->first_name." ". $client->last_name;
		$orderID = $request->orderID;

		DB::table('client_album_selections')->where('album_order_id','=',$orderID)->delete();

		//save all photos in album purchase to database
		foreach ($photos as $photo)
		{
			$selectedPhoto = new ClientAlbumSelection();
			$selectedPhoto->album_order_id = $orderID;
			$selectedPhoto->client_album_photo_id = $photo["photo_id"];
			$selectedPhoto->save();
		}

		//send email confirmation to customer and admin
		Mail::send('emails.order_confirmation',[],function($message) use($client,$clientName)
		{
			$message->to($client->email,$clientName)->subject('Album Order Received');
		});

		Mail::send('emails.admin_order_notification',[],function($message)
		{
			$message->to(Config::get('constants.site.OWNEREMAIL'),Config::get('constants.site.OWNERNAME'))->subject('Album Order Received');
		});

		Session::flash('message', FlashMessage::DisplayAlert('Your album purchase was saved!', 'success'));
	}//end edit album purchase


	public function printsPurchase(Request $request)
	{
		$photos = $request->photos;
		$albumID = $request->album_id;
		$album = ClientAlbum::find($albumID);
		$client = $album->client;
		$clientName = $client->first_name." ". $client->last_name;

		//create prints order in database
		$order = new Order();
		$order->client_album_id = $albumID;
		$order->client_id = $client->id;
		$order->status = "In Progress";
		$order->type = "Prints Order";
		$order->save();

		foreach ($photos as $photo)
		{
			$selectedPhoto = new ClientPrintsSelection();
			$selectedPhoto->print_order_id = $order->id;
			$selectedPhoto->client_album_photo_id = $photo["photo_id"];
			$selectedPhoto->format_id = $photo["format_id"];
			$selectedPhoto->quantity = $photo["quantity"];
			$selectedPhoto->save();
		}

		//send email confirmation to customer and admin
		Mail::send('emails.order_confirmation',[],function($message) use($client,$clientName)
		{
			$message->to($client->email,$clientName)->subject('Prints Order Received');
		});

		Mail::send('emails.admin_order_notification',[],function($message)
		{
			$message->to(Config::get('constants.site.OWNEREMAIL'),Config::get('constants.site.OWNERNAME'))->subject('Prints Order Received');
		});
		Session::flash('message', FlashMessage::DisplayAlert('Your prints purchase was successful!', 'success'));
	}//end printsPurchase

	public function editPrintsPurchase(Request $request)
	{
		$photos = $request->photos;
		$user = \Auth::user();
		$client = $user->client;
		$clientName = $client->first_name." ". $client->last_name;
		$orderID = $request->orderID;

		DB::table('client_prints_selections')->where('print_order_id','=',$orderID)->delete();

		foreach ($photos as $photo)
		{
			$selectedPhoto = new ClientPrintsSelection();
			$selectedPhoto->print_order_id = $orderID;
			$selectedPhoto->client_album_photo_id = $photo["photo_id"];
			$selectedPhoto->format_id = $photo["format_id"];
			$selectedPhoto->quantity = $photo["quantity"];
			$selectedPhoto->save();
		}

		//send email confirmation to customer and admin
		Mail::send('emails.order_confirmation',[],function($message) use($client,$clientName)
		{
			$message->to($client->email,$clientName)->subject('Prints Order Received');
		});

		Mail::send('emails.admin_order_notification',[],function($message)
		{
			$message->to(Config::get('constants.site.OWNEREMAIL'),Config::get('constants.site.OWNERNAME'))->subject('Prints Order Received');
		});
		Session::flash('message', FlashMessage::DisplayAlert('Your prints purchase was saved!', 'success'));
	}//end edit printsPurchase
}
