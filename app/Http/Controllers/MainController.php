<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;

class MainController extends Controller
{
    public function __construct()
    {
//        $this->middleware();
    }

    //
    public function index()
    {
//        $token = $request->session()->get('fb_user_access_token');
//
////        $groupsManaged = $fb->get('/me/groups', $token, [])->getPaginationResult();
//        $groupsManaged = $fb->sendRequest('get', '/me/groups', [], $token)->getBody();
//        $groupsManaged = json_decode($groupsManaged);
//        $pagesLiked = $fb->sendRequest('get', '/me/likes', [], $token)->getBody();
//        $pagesLiked = json_decode($pagesLiked);
        return view('app.comparison');
    }

    public function getDataFromFB(LaravelFacebookSdk $fb, Request $request)
    {
        $token = $request->session()->get('fb_user_access_token');
//        $groupsManaged = $fb->get('/me/groups', $token, [])->getPaginationResult();
        $groupsManaged = $fb->sendRequest('get', '/me/groups', [], $token)->getBody();
        $pagesLiked = $fb->sendRequest('get', '/me/likes', ['limit' => 100], $token)->getBody();

//        $fb->sendRequest('post', '/111799155842529/feed', ['message' => 'HOLA DESDE LA API'], $token); //PAGE PSM
//        $fb->sendRequest('post', '/446028878930046/feed', ['message' => 'HOLA DESDE LA API'], $token); // GROUP NELgit
        return response()->json(['groups' => json_decode($groupsManaged), 'pages' => json_decode($pagesLiked)]);
//        return view('app.comparison', ['groups' => $groupsManaged, 'pages' => $pagesLiked]);
    }

}
