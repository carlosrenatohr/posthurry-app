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
        if ($request->has('package')) {

            $login_url = $fb->getLoginUrl([], url('/plans/' . $request->get('package')));

        } else {

            $login_url = $fb->getLoginUrl();

        }

        return redirect($login_url);
    }
}