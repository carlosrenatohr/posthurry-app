<?php
namespace App\Http\Controllers;

use App\User;
use Facebook\Exceptions\FacebookSDKException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;

class AccessController extends Controller
{

    protected $fb;

    public function __construct(LaravelFacebookSdk $fb)
    {
        $this->fb = $fb;
    }

    public function index(Request $request)
    {
        return view('layouts.main-page', ['withoutHeader' => true]);
    }

    public function getLogin(Request $request)
    {
        return view('layouts.login');
    }

    public function postLogin(Request $request)
    {
        if( Auth::attempt( 
                [
                    'email'      => $request->get( 'email' ),
                    'password'   => $request->get( 'password' )
                ] 
            ) 
        )
        {
            return redirect( url( 'blasting' ) );
        }

        return redirect()->back()->with( 'error-msg', 'The email address and password do not match.' );
    }

    public function getSignup(Request $request)
    {
        $package = 'trial';

        if( Auth::check()){
            return redirect('/blasting');
        }

        if( $request->has( 'package' ) ) {
             $package = $request->get( 'package' );
        }

         return view('layouts.signup', compact('user', 'package'));
    }

    public function postSignup(Request $request)
    {
        if(!$request->has('acceptTerms')) {
            return redirect()->back()->with('error-msg', 'You must accept terms and conditions!');
}
        $userFound = User::where( 'email', $request->get( 'email' ) )->get();

        if( ! $userFound->isEmpty() ){
            return redirect()->back()->with( 'error-msg', 'Your email has been registered, please do login instead' );
        }
        
        $user =  $this->createUsers( $request->all() );

        Auth::loginUsingId( $user->id );

        $request->session()->put('logged_in', $user->id);

        if( $request->get( 'package' ) == 'trial' ) {
    
            return redirect('/blasting')->with('success-msg', "Your account was created successfully, Welcome " . $user->name . "!");
        } else {

            return redirect('/plans/' . $request->get( 'package' ) );
        }
    }

    protected function createUsers( $data ) {
        $user = new User();
        $user->name              = $data[ 'name' ];
        $user->email             = $data[ 'email' ];
        $user->password          = Hash::make( $data[ 'password' ] );
        $user->active_package    = $data[ 'package' ];
        $user->save();

        return $user;
    }

    public function getLoginUrl(Request $request)
    {
        $request->session()->put('linkToReturn', $request->get('toReturn'));
        return response()->json([
//            'url' => $this->fb->getRedirectLoginHelper()->getLoginUrl()
            'url' => $this->fb->getLoginUrl()
        ]);
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
            return redirect('/')->with('error-msg', 'Problem authenticating!');
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

        
        return redirect('/blasting')->with('success-msg', htmlentities("Successfully logged in with Facebook, Welcome " . $user->name . "!"));
    }

    public function logout(Request $request)
    {
        
        Auth::logout();

        $request->session()->flush();

        return redirect('/');
    }

}
