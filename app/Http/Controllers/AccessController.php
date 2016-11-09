<?php
namespace App\Http\Controllers;

use Mail;
use App\User;
use Facebook\Exceptions\FacebookSDKException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Vinkla\Hashids\HashidsManager;

class AccessController extends Controller
{
    use ResetsPasswords;

    protected $fb, $hashid;

    public function __construct(LaravelFacebookSdk $fb, HashidsManager $hashid)
    {
        $this->fb = $fb;
        $this->hashid = $hashid;
    }

    public function index(Request $request)
    {
        return view('layouts.main-page', ['withoutHeader' => true, 'referral' => null]);
    }

    public function referral($referral=null)
     {
         if($referral){
             $checkReferral = User::where('referral', $referral)->first();
             if($checkReferral && !(session()->get('logged_in') === $checkReferral->id)){
                 return view('layouts.main-page', ['withoutHeader' => true, 'referral'=>$referral]);
             }
            return view('layouts.main-page', ['withoutHeader' => true, 'referral'=>null]);
         }
 
         return view('layouts.main-page', ['withoutHeader' => true, 'referral'=>null]);
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
            // check if user comes with referral code
            if($request->session()->get('referral') && $request->session()->get('package_type')){
                    $referral = $request->session()->get('referral');
                    $package = $request->session()->get('package_type');
                    $checkReferral = User::where('referral', $referral)->get();
                    if(count($checkReferral)>0){
                        return redirect('plans/'.$package.'/'.$referral);
                    }
             return redirect('/blasting')->with('success-msg', "Your account was created successfully, Welcome " . $user->name . "!");
         }else{
            return redirect('/blasting')->with('success-msg', "Your account was created successfully, Welcome " . $user->name . "!");
         }
//            return redirect('/plans/' . $request->get( 'package' ) );
        }
    }

    protected function createUsers( $data ) {
        $user = new User();
        $user->name              = $data[ 'name' ];
        $user->email             = $data[ 'email' ];
        $user->password          = Hash::make( $data[ 'password' ] );
        $user->timezones         = $data[ 'timezones' ];
        $user->active_package    = $data[ 'package' ];
        $hashids = $this->hashid->encode(time());
        $user->referral = str_random(10); // generate a referral code
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

                // save the user token and fb user id
                User::where( 'id', Auth::user()->id )
                        ->update( [ 
                        'facebook_user_id' => $user->id,
                        'access_token'     => $request->session()->get( 'fb_user_access_token' )
                        ] );

                
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

    public function getForget(Request $request)
    {
        return view('auth.emails.password', ['token' => str_random(), 'user' => Auth::user()]);
//        return view('layouts.forget-password');
    }

}
