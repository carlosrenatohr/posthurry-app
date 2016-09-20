<?php

namespace App\Http\Middleware\Hurrypost;

use Closure;
use Auth;

class IsUserIn
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
        if($request->session()->has('logged_in') || !Auth::check() ) {
            return redirect('/');
        }
        return $next($request);
    }
}
