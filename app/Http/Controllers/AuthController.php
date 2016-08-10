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
        // get fb login url
        $login_url = $fb->getLoginUrl();

        if ($request->has('package')) {

            $login_url .= "&state=gogo";

        }

        return redirect($login_url);
    }

    public function fbCallback(Request $request)
    {
        if ($request->has('state')) {
            return redirect(url('/plans/' . $request->get('state')));
        }

        return redirect('/')->with('message', 'Successfully logged in with Facebook');
    }
}