<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\StoreClientAlbumRequest;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;
use App\PortfolioAlbum;
Use App\PortfolioAlbumPhoto;
use Illuminate\Http\Request;
Use App\Commands\DeleteFolderFileCommand;
use App\helpers\FlashMessage;

class PortfolioAlbumsController extends Controller {

	/**
	 * Display a listing of the portfolio albums.
	 *
	 * @return Response
	 */
	public function index()
	{
		$portfolios = PortfolioAlbum::paginate(12);
		$title = "Website Portfolio";
		return view('admin.portfolio_index')->with('title', $title)
												->with('portfolios',$portfolios);
	}

	/**
	 * Store a newly created portfolio album in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$portfolio = new PortfolioAlbum();
		$portfolio->name = $request->name;
		$portfolio->save();
		mkdir(public_path("assets/images/portfolio_albums/".$portfolio->id),0777,true);
	}

	/**
	 * Display the specified portfolio album.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$portfolio = PortfolioAlbum::find($id);
		$photos = PortfolioAlbumPhoto::where("portfolio_album_id","=",$id)->paginate(12);
		return View('admin.single_portfolio')->with('title', $portfolio->name)
										 ->with('photos',$photos)
										 ->with('portfolio_id',$id);
	}


	/**
	 * Remove the specified portfolio album from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$portfolio = PortfolioAlbum::find($id);

		//delete folder and Photos from server
		$this->dispatch(new DeleteFolderFileCommand(public_path("assets/images/portfolio_albums/".$id)));

		//delete from database
		PortfolioAlbumPhoto::where("portfolio_album_id","=",$id)->delete();
		$portfolio->delete();

		return redirect('/admin/dashboard/portfolio')
				->with('message',FlashMessage::DisplayAlert('Successfully deleted album!', 'success'));
		
	}

	/**
	 *	Deletes a photo in the portfolio album
	 */
	public function deleteAlbumPhoto($id)
	{
		$photo = PortfolioAlbumPhoto::find($id);
		unlink(public_path($photo->photo_path));
		$photo->delete();
		return redirect()->back();
	}

}
