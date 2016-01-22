<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuth
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->segment(2) == 'auth' || $request->segment(2) == 'password') {
            if (Auth::admin()->check()) {
                if (stripos($request->route()->getActionName(), 'getLogout') === FALSE) {
                    return redirect('admin/dashboard');
                }
            }
            return $next($request);
        }
        if (!Auth::admin()->check() && !Auth::admin()->viaRemember()) {
            return redirect('admin/auth/login');
        }
        return $next($request);
    }

}
