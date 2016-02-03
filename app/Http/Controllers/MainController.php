<?php
namespace App\Http\Controllers;
use App\Comparison;
use App\Http\Requests;
use Illuminate\Http\Request;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;

class MainController extends Controller
{
    protected $fb;
    public function __construct(LaravelFacebookSdk $fb)
    {
        $this->fb = $fb;
    }

    //
    public function index()
    {
        return view('app.comparison');
    }

    public function getDataFromFB(Request $request)
    {
        $token = $request->session()->get('fb_user_access_token');
//        $groupsManaged = $fb->get('/me/groups', $token, [])->getPaginationResult();
        $groupsManaged = $this->fb->sendRequest('get', '/me/groups', ['limit' => 100], $token)->getBody();
        $pagesLiked = $this->fb->sendRequest('get', '/me/likes', ['limit' => 100], $token)->getBody();

        return response()->json(['groups' => json_decode($groupsManaged), 'pages' => json_decode($pagesLiked)]);
//        return view('app.comparison', ['groups' => $groupsManaged, 'pages' => $pagesLiked]);
    }

    public function postByUserSelected(Request $request) {
        $token = $request->session()->get('fb_user_access_token');
        $input = array_except($request->all(), ['_token', 'typeToPost']);

        // POST text sent by client to respect groups
         $post1_post_id = $this->fb->sendRequest('post', '/'. $input['post1_page_id'] .'/feed', ['message' => $input['post1_text']], $token)->getBody();
         $post1_post_id = json_decode($post1_post_id);
        $input['post1_post_id'] = $post1_post_id->id;
        $post2_post_id = $this->fb->sendRequest('post', '/'. $input['post2_page_id'] .'/feed', ['message' => $input['post2_text']], $token)->getBody();
        $post2_post_id = json_decode($post2_post_id);
         $input['post2_post_id'] = $post2_post_id->id;
        //$this->fb->sendRequest('post', '/111799155842529/feed', ['message' => 'HOLA DESDE LA API'], $token); //PAGE PSM
//         $this->fb->sendRequest('post', '/446028878930046/feed', ['message' => 'HOLA DESDE LA API'], $token); // GROUP NELgit
        $comparison = Comparison::create($input);
        dd($comparison);


        // GET LIKES, shares, comments
//        $post1_post_id = $this->fb->sendRequest('get', '/446028878930046_447000985499502/likes', [], $token)->getBody();
//        $post1_post_id = $this->fb->sendRequest('get', '/446028878930046_447000985499502/sharedposts', [], $token)->getBody();
//        $post1_post_id = $this->fb->sendRequest('get', '/446028878930046_447000985499502/comments', [], $token)->getBody();
    }

}
