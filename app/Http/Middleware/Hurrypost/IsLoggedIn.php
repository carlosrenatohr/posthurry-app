<?php

namespace App\Http\Middleware\Hurrypost;

use Closure;

class isLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$request->session()->has('fb_user_access_token')) {
            return redirect('/');
        }
        return $next($request);
    }
}
