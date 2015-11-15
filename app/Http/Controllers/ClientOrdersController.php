<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Order;
use App\ClientAlbumPhoto;
use App\PhotoFormat;
class ClientOrdersController extends Controller {

	public function __construct()
    {
        $this->middleware('orderprivacy', ['only' => ['edit', 'cancel']]);
    }
	/**
	 * Display a listing of client orders.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = \Auth::user();
		$client = $user->client;
		$allOrders = Order::where('client_id','=',$client->id)->orderBy('created_at','DESC')->get();

		return view('clients.orders')->with('allOrders',$allOrders);
	}

	/**
	 * Show the form for editing a client's order.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$order = Order::find($id);
		$album = $order->album;
		$itemsPerPage = 12;
		$total = ClientAlbumPhoto::where('client_album_id','=',$album->id)->count();
		$last = ceil($total/$itemsPerPage);
		if(strcmp($order->type, 'Prints Order') == 0)
		{
			return View('clients.purchase_prints')->with('title',$album->album_name)
												 ->with('albumID',$album->id)
												 ->with('last',$last)
												 ->with('itemsPerPage',12)
												 ->with('orderID',$id);
		}
		else //is an album order
		{
			return View('clients.purchase_album')->with('title',$album->album_name)
											 ->with('albumID',$album->id)
											 ->with('last',$last)
											 ->with('itemsPerPage',12)
											 ->with('orderID',$order->id)
											 ->with('maxPhotos',$album->photo_selection_max);
		}
	}

	/**
	 *	Updates database to cancel client order
	 */
	public function cancel($id)
	{
		$order = Order::find($id);
		$order->status = 'Canceled';
		$order->save();

		return redirect('/user/dashboard/orders_history');
	}

}
