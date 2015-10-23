<?php namespace App\Http\Middleware;

use Closure;

class ClientsOnly {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if($request->user()->is_admin)
		{
			return redirect('/admin/dashboard');
		}
		if(!($request->user()->is_active))
		{
			\Auth::logout();
			return redirect('/auth/login')->withErrors(['deactivated'=>'Your account has been deactivated.  Contact admin for more information.']);
		}
		return $next($request);
	}

}
