<?php namespace App\Http\Middleware;
use App\Order;
use App\ClientAlbum;
use Closure;

class OrderPrivacy {

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
			$order_id = $tokens[sizeof($tokens)-1];
		else
			$order_id = $tokens[sizeof($tokens)-2];

		$order = Order::find($order_id);
		if($order!=null){
			$album = $order->album;
			$album_user = $album->client->user;
		}
		if($order==null || $request->user()->id != $album_user->id)
			return redirect('/user/dashboard');
		
		return $next($request);
	}

}
