<?php namespace App\Http\Middleware;
use \App\ClientAlbum;
use Closure;

class AlbumPrivacy {

	/**
	 * Handle an incoming request.
	 * This middleware ensures that no logged on client can
	 * view or order another clients albums.
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$uri = $_SERVER['REQUEST_URI'];
		$tokens = explode('/', $uri);
		if(count($tokens) == 5)
			$album_id = $tokens[sizeof($tokens)-1];
		else
			$album_id = $tokens[sizeof($tokens)-2];
		
		$album = ClientAlbum::find($album_id);
		if($album != null){
			$album_user = $album->client->user;
		}

		if($album == null || $request->user()->id != $album_user->id)
			return redirect('/user/dashboard');
		return $next($request);
	}

}
