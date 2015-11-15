<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Order;
use Config;
use Response;

use Illuminate\Http\Request;

class AdminOrderController extends Controller {

	/**
	 * Display a listing of orders.
	 *
	 * @return Response
	 */
	public function index()
	{
		$pendingOrders = Order::where('status','=','In Progress')->orderBy('created_at','DESC')->get();
		$nonPendingOrders = Order::where('status','!=','In Progress')->orderBy('created_at','DESC')->get();


		return View('admin.index_orders')->with('pendingOrders',$pendingOrders)
										->with('nonPendingOrders',$nonPendingOrders)
										->with('title','Orders');
	}

	/*
	 *	Receives an ajax request to update the status of an order
	 */
	public function updateStatus(Request $request)
	{
		$order = Order::find($request->orderID);
		$order->status = $request->status;
		$order->save();
	}

	/**
	 *	Recieves an ajax request to download an order
	*/
	public function download(Request $request)
	{		
		$order = Order::find($request->orderID);

	    // create new zip opbject
	    $zip = new \ZipArchive();

	    // create a temp file & open it
	    $tmp_file = tempnam('.zip','');
	    $file_name = $tmp_file;
	    $zip->open($tmp_file, \ZipArchive::CREATE);

		if(strcmp($order->type,'Album Order') == 0)
		{
			$selections = $order->albumSelections;
			
			$i=1;
			//loop through all files
			foreach($selections as $selection)
			{
		        //add file to the zip
		        $zip->addFile(public_path($selection->photo->photo_path_high_res),$i.'.jpg');
		        $i++;
			}
		}
		else
		{
			$selections = $order->printsSelections;

			$i=1;
			//loop through all files
			foreach($selections as $selection)
			{
		        //add file to the zip
		        $zip->addFile(public_path($selection->photo->photo_path_high_res),$i.' '.$selection->format->format.' '.$selection->quantity.'.jpg');
		        $i++;
			}
		}

		// close zip
    	$zip->close();

		//send the file to the browser as a download
		return response()->download($tmp_file,'orders.zip')->deleteFileAfterSend(true);		
	}//end download fuction

}//end class AdminOrderController
