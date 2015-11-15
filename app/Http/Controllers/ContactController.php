<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contact;
use App\Http\Requests\ContactRequest;
use App\Commands\ContactCommand;
use App\helpers\FlashMessage;

class ContactController extends Controller {

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function index()
	{
		$contact = Contact::first();
		return View('admin.contact')->with('title','Edit Contact Page')
								  ->with('contact',$contact);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(ContactRequest $request,$id)
	{
		$this->dispatch(new ContactCommand($id,$request->title,$request->address,$request->city,
											$request->state,$request->zip,
											$request->email,$request->phone));
		return redirect()->back()
			->with('message',FlashMessage::DisplayAlert('Successfully updated!', 'success'));
	}

}
