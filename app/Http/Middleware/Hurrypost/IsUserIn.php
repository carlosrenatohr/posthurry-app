<?php

namespace App\Http\Middleware\Hurrypost;

use Closure;

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
        if($request->session()->has('logged_in')) {
            return redirect('/');
        }
        return $next($request);
    }
}
