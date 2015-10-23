<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ClientUserRequest;
use App\Http\Requests\UpdateClientUserRequest;
use App\Commands\CreateClientUserCommand;
use Intervention\Image\ImageManagerStatic as Image;
use App\Client;
use App\User;
use App\ClientAlbumPhoto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Commands\DeleteFolderFileCommand;
use Illuminate\Pagination\Paginator;
use App\helpers\FlashMessage;

class ClientsController extends Controller {

	/**
	 * Display a listing of clients.
	 *
	 * @return Response
	 */
	public function index()
	{
		$clients = Client::paginate(12);
		return view('admin.index_clients')->with('title','View Clients')
									->with('clients',$clients);
	}

	/**
	 *	Searchs database for clients that match search terms
	 */
	public function search()
	{
		$q = Input::get('search_terms');

    	$searchTerms = explode(' ', $q);

    	$query = DB::table('clients');

    	foreach($searchTerms as $term)
	    {
	        $query->where('first_name', 'LIKE', '%'. $term .'%')
	        	  ->orWhere('last_name', 'LIKE', '%'. $term .'%');
	    }

	    $results = $query->paginate(12);

	    return view('admin.index_clients')->with('title','View Clients')
									->with('clients',$results);

	}

	/**
	 * Show the form for creating a new client.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('admin.create_clients')->with('title','Create Client');
	}

	/**
	 * Store a newly created client in storage.
	 *
	 * @return Response
	 */
	public function store(ClientUserRequest $request)
	{
		$path=null;
		$filename=null;
		$profile_photo = $request->files->get('profile_photo');
		
		//if profile exists upload profile photo server
		if ($profile_photo)
		{
			$filename = time()."-". $profile_photo->getClientOriginalName();
			$path = public_path('assets/images/profile_photo/'. $filename);

			//open image file
			$image = Image::make($profile_photo->getRealPath());

			//resize and save file to server
			$image->resize(null, 600, 
					function ($constraint) 
					{
						$constraint->aspectRatio();
						$constraint->upsize();
					})->save($path,100);
		}

		//Create user/client accounts
		try{
			$this->dispatch(new CreateClientUserCommand(
						($filename? 'assets/images/profile_photo/'. $filename : null),
						$request->first_name,$request->last_name,$request->email,
						$request->phone_1,$request->phone_2,$request->address_1,
						$request->address_2,$request->city,$request->state,
						$request->zip,bcrypt($request->password)));
		} catch(\Exception $e)
		{
			//If new user/client could not be added to database
			//Delete profile photo if it exists
			//Then redirect back to page with error message
			if($path)
				unlink($path);
			return redirect()->back()->withInput()
					->with('message',FlashMessage::DisplayAlert('Could not create user/client in database.  Please try again.', 'success'));
		}

		return redirect()->back()
			->with('message',FlashMessage::DisplayAlert('User/Client has been successfully added', 'success'));
	}

	/**
	 * Show the form for editing the client resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$client = Client::find($id);
		$user = $client->user;
		return View('admin.edit_clients')
				->with('title','Edit Client')
				->with('client',$client)
				->with('user',$user);
	}

	/**
	 * Update the specified client in storage.
	 *
	 * @param  UpdateClientUserRequest $request, int  $id
	 * 
	 * @return Response
	 */
	public function update(UpdateClientUserRequest $request,$id)
	{
		$profile_photo = $request->files->get('profile_photo');
		$client = Client::find($id);
		$user = $client->user;

		//If new profile photo was select
		if($profile_photo)
		{
			//delete old profile photo if one does exists
			if($client->profile_photo)
				unlink(public_path($client->profile_photo));

			$filename = time()."-". $profile_photo->getClientOriginalName();
			$path = public_path('assets/images/profile_photo/'. $filename);

			//open image file
			$image = Image::make($profile_photo->getRealPath());

			//resize and save file to server
			$image->resize(null, 600, 
					function ($constraint) 
					{
						$constraint->aspectRatio();
						$constraint->upsize();
					})->save($path,100);  //save new photo

			$client->profile_photo = 'assets/images/profile_photo/'. $filename;
		}

		//save client data
		$client->first_name = $request->first_name;
		$client->last_name = $request->last_name;
		$client->email = $request->email;
		$client->phone_1 = $request->phone_1;
		$client->phone_2 = $request->phone_2;
		$client->address_1 = $request->address_1;
		$client->address_2 = $request->address_2;
		$client->city = $request->city;
		$client->state = $request->state;
		$client->zip = $request->zip;
		$client->save();

		//save user data
		if($request->password)
			$user->password = bcrypt($request->password);
		$user->is_active = $request->is_active;
		$user->email = $request->email;
		$user->save();

		return redirect()->back()->with('message',FlashMessage::DisplayAlert('User/Client has been successfully edited', 'success'));
	}

	/**
	 * Remove the specified client from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$client = Client::find($id);
		if(count($client->orders))
		{
			return redirect()->back()
				->with('message',FlashMessage::DisplayAlert('Cannot delete a client that has an order.', 'success'));
		}
		else
		{
			$albums = $client->albums;
			foreach($albums as $album)
			{
				//delete folder and Photos from server
				$this->dispatch(new DeleteFolderFileCommand(public_path("assets/images/client_albums/".$album->id)));
				unlink(public_path($album->album_cover_photo));

				//delete from database
				ClientAlbumPhoto::where("client_album_id","=",$album->id)->delete();
				$album->delete();
			}
			if($client->profile_photo) unlink(public_path($client->profile_photo));
			$user = $client->user;
			$client->delete();
			$user->delete();
			
			return redirect('/admin/dashboard/clients');
		}
		
	}
}
