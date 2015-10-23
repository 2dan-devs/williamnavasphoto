<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/',function(){
	return View('index');
});

Route::controllers([
	'auth' => 'Auth\AuthController'
]);

Route::post('frontendapi/getAllPortfolioAlbums','FrontEndController@getAllPortfolioAlbums');
Route::post('frontendapi/getPortfolioAlbumPhotos','FrontEndController@getPortfolioAlbumPhotos');
Route::post('frontendapi/getContact','FrontEndController@getContact');
Route::post('frontendapi/getAbout','FrontEndController@getAbout');
Route::post('frontendapi/post_message','FrontEndController@postMessage');

Route::group(['middleware' => 'auth'], function(){
	Route::group(['middleware' => 'adminonly'], function(){
		Route::get('admin/dashboard', function()
		{
			return View('admin.dashboard')->with('title','Administrator');
		});
		Route::resource('admin/dashboard/orders', 'AdminOrderController');
		Route::post('admin/dashboard/orders/update_status', 'AdminOrderController@updateStatus');
		Route::post('admin/dashboard/orders/download', 'AdminOrderController@download');
		Route::resource('admin/dashboard/portfolio', 'PortfolioAlbumsController');
		Route::resource('admin/dashboard/clients/{id}/albums', 'ClientAlbumsController');
		Route::post('admin/dashboard/clients/search', 'ClientsController@search');
		Route::resource('admin/dashboard/clients', 'ClientsController');
		Route::resource('admin/dashboard/about', 'AboutController');
		Route::resource('admin/dashboard/contact', 'ContactController');
		Route::post('submit/album_photos','SubmitController@albumPhotos');
		Route::post('submit/portfolio_photos','SubmitController@portfolioPhotos');
		Route::delete('submit/album_photos/{id}/delete','ClientAlbumsController@deleteAlbumPhoto');
		Route::delete('submit/portfolio_photos/{id}/delete','PortfolioAlbumsController@deleteAlbumPhoto');
	});
	Route::group(['middleware' => 'activeclientsonly'], function(){
		Route::get('user/dashboard', function()
		{
			$user = \Auth::user();
			$client = $user->client;
			$albums = App\ClientAlbum::where('client_id','=',$client->id)->orderBy('created_at','DESC')->paginate(6);
			return View('clients.dashboard')->with('albums',$albums)
											->with('client',$client);
		});
		Route::post('get/album_photos','ClientAlbumsController@getAlbumPhotos');
		Route::resource('user/dashboard/purchase_album', 'PurchaseAlbumController');
		Route::resource('user/dashboard/purchase_prints', 'PurchasePrintsController');
		Route::resource('user/dashboard/orders_history', 'ClientOrdersController');
		Route::get('user/dashboard/orders_history/{id}/cancel','ClientOrdersController@cancel');
		Route::post('submit/album_purchase','SubmitController@albumPurchase');
		Route::post('submit/prints_purchase','SubmitController@printsPurchase');
		Route::post('submit/edit_album_purchase','SubmitController@editAlbumPurchase');
		Route::post('submit/edit_prints_purchase','SubmitController@editPrintsPurchase');
	});
	
	
});