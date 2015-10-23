<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\About;
use App\Http\Requests\AboutRequest;
use App\Commands\AboutCommand;
use App\helpers\FlashMessage;

class AboutController extends Controller {	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function index()
	{
		$about = About::first();
		return View('admin.about')->with('title','Edit About Page')
								  ->with('about',$about);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(AboutRequest $request,$id)
	{
		$this->dispatch(new AboutCommand($id,$request->title,$request->body));
		return redirect()->back()->with('message', FlashMessage::DisplayAlert('Successfully updated!', 'success'));
	}


}
