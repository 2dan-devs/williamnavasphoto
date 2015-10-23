<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ClientAlbum;
use App\ClientAlbumPhoto;

class PurchaseAlbumController extends Controller {

	public function __construct()
    {
        $this->middleware('albumprivacy');
    }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$album = ClientAlbum::find($id);
		$itemsPerPage = 12;
		$total = ClientAlbumPhoto::where('client_album_id','=',$id)->count();
		$last = ceil($total/$itemsPerPage);
		return View('clients.purchase_album')->with('title',$album->album_name)
											 ->with('last',$last)
											 ->with('itemsPerPage',12)
											 ->with('albumID',$id)
											 ->with('maxPhotos',$album->photo_selection_max);
	}
}
