<?php
/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 08-09-16
 * Time: 12:37 AM
 */
namespace App\Http\Controllers;

use App\Library\Repositories\BlastingRepository;
use App\User;
use App\Library\Repositories\PostsPerDayRepository;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;
use Symfony\Component\HttpFoundation\Request;

class BlastingController extends Controller
{

    protected $fb, $postsPerDay;
    public function __construct(LaravelFacebookSdk $fb,
        PostsPerDayRepository $postsperday,
        BlastingRepository $blast
    ) {
    
        $this->fb = $fb;
        $this->postsPerDay = $postsperday;
        $this->blasting = $blast;
    }

    public function index() 
    {
        $user_id = Auth::user()->id;
        $user = User::with( [ 'blasting' => function( $table ) {
           return $table->groupBy( 'code' ); 
        } ] )->find($user_id);

        return view('blasting.index', ['user' => $user]);
    }

    public function getBlastingOutForm( Request $request ) 
    {
        $fb = true;

        if (Auth::check() && !empty(Auth::user()->access_token) ) {
            $request->session()->put('fb_user_access_token', Auth::user()->access_token);
        }

        if(!$request->session()->has('fb_user_access_token')) {
             $fb_login_url = $this->fb->getLoginUrl();
             $request->session()->flash('error-msg', 'Connect your Facebook account to view your Groups and Pages. <a href="'.$fb_login_url.'" class="btn btn-primary">Connect with facebook.</a>');

             $fb = false;
        }

        return view('app.blasting_form', compact('fb'));

    }

    /**
     * @description Action to blast posts out in mass
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postBlastingOut(Request $request) 
    {
        if (!$this->postsPerDay->limitPerDayIsOver(Auth::user()->id)) {
            $massGroup = $request->get('massPosts');
            $token = $request->session()->get('fb_user_access_token');
            $this->blasting->startBlastOut($massGroup, $token, $request);

            return redirect('/blasting-posts')->with('success-msg', 'Blasting out your post successfully!');
        } else {
            return redirect()->back()->with('error-msg', "You have exceeded the limit of posts per day.");
        }
    }
}
