<?php
namespace App\Http\Middleware\Hurrypost;
use App\User;
use Closure;

class VerifyUserExists
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
        if ($request->session()->has('fb_user_data')) {
            $user = $request->session()->get('fb_user_data');
            $user = json_decode($user);
            $userFound = User::existsUser($user);
            $request->session()->put('logged_in', $userFound->id);
        }
        return $next($request);
    }
}
