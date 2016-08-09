<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;
use Facebook\Exceptions\FacebookSDKException;

class AccessController extends Controller
{

    protected $fb;

    public function __construct(LaravelFacebookSdk $fb)
    {
        $this->fb = $fb;
    }

    public function index(Request $request)
    {
//        if ($request->session()->has('fb_user_access_token'))
//            return redirect('/posting');
//        else
            return view('layouts.main-page', ['withoutHeader' => true]);

    }

    public function getLoginUrl()
    {
        return response()->json(['url' => $this->fb->getLoginUrl()]);
    }

    public function fbCallback(Request $request)
    {
//        $request->session()->flush();
        try {
            $token = $this->fb->getAccessTokenFromRedirect();
            $this->fb->setDefaultAccessToken($token);
        } catch (FacebookSDKException $e) {
            dd($e->getMessage());
        }
        // Not token found, denied the request
        if (!$token) {
            return redirect('/')->with('message', 'Problem authenticating!');
        } else {
            $request->session()->put('fb_user_access_token', (string)$token);
            try {
                $response = $this->fb->get('/me?fields=id,name,email')->getBody();
                $request->session()->put('fb_user_data', $response);
                $user = json_decode($request->session()->get('fb_user_data'));
            } catch (FacebookSDKException $e) {
                dd($e->getMessage());
            }
        }
        return redirect('/posting')->with('success-msg', htmlentities("Successfully logged in with Facebook, Welcome " . $user->name ."!"));
    }

    public function logout(Request $request) {
        $request->session()->remove('fb_user_access_token');
        $request->session()->remove('fb_user_data');
        return redirect('/');
    }

}