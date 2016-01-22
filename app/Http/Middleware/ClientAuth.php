<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ClientAuth {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        if ($request->segment(1) == 'auth' || $request->segment(1) == 'password') {
            if (Auth::client()->check()) {
                if (stripos($request->route()->getActionName(), 'getLogout') === FALSE) {
                    return redirect('/');
                }
            }
            return $next($request);
        }
        if (!Auth::client()->check() && !Auth::client()->viaRemember()) {
            return redirect('auth/login');
        }
        return $next($request);
	}

}
