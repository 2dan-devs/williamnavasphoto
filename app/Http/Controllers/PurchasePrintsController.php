<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ClientAlbum;
use App\ClientAlbumPhoto;
use App\PhotoFormat;

class PurchasePrintsController extends Controller {

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
		$formats = PhotoFormat::all();
		$album = ClientAlbum::find($id);
		$itemsPerPage = 12;
		$total_rows = ClientAlbumPhoto::where('client_album_id','=',$id)->count();
		$last = ceil($total_rows/$itemsPerPage);
		return View('clients.purchase_prints')->with('title',$album->album_name)
											 ->with('albumID',$id)
											 ->with('last',$last)
											 ->with('itemsPerPage',12)
											 ->with('photo_formats',$formats);
	}
}
