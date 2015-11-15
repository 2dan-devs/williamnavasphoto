<?php namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Requests\StoreClientAlbumRequest;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;
use App\ClientAlbum;
use App\Client;
use App\Order;
Use App\ClientAlbumPhoto;
use Illuminate\Http\Request;
use App\Commands\DeleteFolderFileCommand;
use \Illuminate\Support\Facades\DB;
use App\helpers\FlashMessage;

class ClientAlbumsController extends Controller {

	/**
	 * Display a listing of client's albums.
	 *
	 * @return Response
	 */
	public function index($id)
	{
		$client = Client::find($id);
		$albums = $client->albums;
		$title = $client->first_name.' '.$client->last_name.' Albums';
		return view('admin.client_albums_index')->with('title', $title)
												->with('id',$id)
												->with('albums',$albums);
	}

	/**
	 * Store a newly created client album in storage.
	 *
	 * @return Response
	 */
	public function store(StoreClientAlbumRequest $request)
	{
		$cover_photo = $request->files->get('album_cover_photo');
		$client_album = new ClientAlbum();

		$filename = time()."-". $cover_photo->getClientOriginalName();
		$path = public_path('assets/images/album_cover_photo/'. $filename);

		//open image file
		$image = Image::make($cover_photo->getRealPath());

		//resize and save file to server
		$image->resize(null, 600,
				function ($constraint)
				{
					$constraint->aspectRatio();
					$constraint->upsize();
				})->save($path,90);  //save new photo

		$client_album->album_cover_photo = 'assets/images/album_cover_photo/'.$filename;

		$client_album->album_name = $request->album_name;
		$client_album->client_id = $request->client_id;
		$client_album->photo_selection_max = $request->photo_selection_max;
		$client_album->save();

		mkdir(public_path("assets/images/client_albums/".$client_album->id."/high_res"),0777,true);
		mkdir(public_path("assets/images/client_albums/".$client_album->id."/low_res"),0777,true);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($client_id,$album_id)
	{
		$album = ClientAlbum::find($album_id);
		$photos = ClientAlbumPhoto::where("client_album_id","=",$album_id)->paginate(12);
		return View('admin.single_album')->with('title', $album->album_name)
										 ->with('photos',$photos)
										 ->with('album_id',$album_id);
	}


	/**
	 * Deletes a client album if there are no orders made on album.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($client_id,$album_id)
	{
		$album = ClientAlbum::find($album_id);

		if(count($album->orders))
		{
			return redirect()->back()->with('message', FlashMessage::DisplayAlert('Cannot delete album.  This album has been ordered by client', 'success'));
		}
		else
		{
			$coverPhoto = $album->album_cover_photo;
			$albumPhotos = $album->photos;

			//delete folder and Photos from server
			$this->dispatch(new DeleteFolderFileCommand(public_path("assets/images/client_albums/".$album_id)));
			unlink(public_path($album->album_cover_photo));

			//delete from database
			ClientAlbumPhoto::where("client_album_id","=",$album_id)->delete();
			$album->delete();

			return redirect('/admin/dashboard/clients/'.$client_id.'/albums')->with('message', FlashMessage::DisplayAlert('Successfully deleted album!', 'success'));
		}
	}




	public function deleteAlbumPhoto($id)
	{
		$photo = ClientAlbumPhoto::find($id);
		if(count($photo->printsOrderSelection) || count($photo->albumOrderSelection))
		{
			return redirect()->back->with('message','Cannot delete a photo that is in an order.');
		}
		else
		{
			unlink(public_path($photo->photo_path_low_res));
			unlink(public_path($photo->photo_path_high_res));
			$photo->delete();
			return redirect()->back();
		}
	}


	public function getAlbumPhotos(Request $request)
	{
		$itemsPerPage = $request->itemsPerPage;
		$page = $request->pn;
		$last = $request->last;
		if($page<1) $page=1;
		else if($page>$last) $page = $last;

		$album_id = $request->album_id;
		$photos = DB::table('client_album_photos')->where('client_album_id','=',$album_id)
												->skip(($page-1)*$itemsPerPage)
												->take($itemsPerPage)->get();

		return response()->json($photos);
	}

	public function loadOrderedAlbum(Request $request)
	{
		$order = Order::find($request->orderID);
		return response()->json($order->albumSelections);
	}

	public function loadOrderedprints(Request $request)
	{
		$order = Order::find($request->orderID);
		return response()->json($order->printsSelections);
	}

}
