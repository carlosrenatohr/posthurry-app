<?php
/**
 * Created by PhpStorm.
 * @author yogasukma <mail.yogasukma@gmail.com>
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;

class AuthController extends Controller
{
    public function fbConnect(LaravelFacebookSdk $fb, Request $request)
    {
        $login_url = $fb->getLoginUrl();

        if (env('APP_ENV') == 'basic') {
            $login_url = $fb->getLoginUrl(['email']);
        }

        if ($request->has('package')) {
            $request->session()->put('selected_package', $request->get('package'));
        }


        return redirect($login_url);
    }

    public function fbCallback(Request $request)
    {
        if ($request->session()->has('selected_package')) {
            return redirect(url('/plans/' . $request->session()->get('selected_package')));
        }

        return redirect('/')->with('message', 'Successfully logged in with Facebook');
    }
}