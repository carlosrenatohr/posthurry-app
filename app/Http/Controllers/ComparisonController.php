<?php
namespace App\Http\Controllers;
use App\Comparison;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;

class ComparisonController extends Controller
{
    protected $comparison;

    public function __construct(Comparison $comparison)
    {
        $this->comparison = $comparison;
    }

    //
    public function index(Request $request)
    {
        $user_id = $request->session()->get('logged_in');
        $user = User::find($user_id);
        return view('comparison.index', ['user' => $user]);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id, Request $request)
    {
        $comparison = $this->comparison->find($id);
        return view('comparison.show', ['comparison' => $comparison]);
    }

    public function postStatsFromFb($id, Request $request, LaravelFacebookSdk $fb)
    {
        $comparison = $this->comparison->find($id);
        $token = $request->session()->get('fb_user_access_token');
        $first = $second = [];
        // First post
        $likes1 = $fb->sendRequest('get', '/'. $comparison->post1_post_id.'/likes', [], $token)->getDecodedBody();
        $first['likes'] = count($likes1['data']);
        $shared1 = $fb->sendRequest('get', '/'. $comparison->post1_post_id .'/sharedposts', [], $token)->getDecodedBody();
        $first['shared'] = count($shared1['data']);
        $comments1 = $fb->sendRequest('get', '/'. $comparison->post1_post_id .'/comments', [], $token)->getDecodedBody();
        $first['comments'] = count($comments1['data']);
        // Second post
        $likes2 = $fb->sendRequest('get', '/'. $comparison->post2_post_id.'/likes', [], $token)->getDecodedBody();
        $second['likes'] = count($likes2['data']);
        $shared2 = $fb->sendRequest('get', '/'. $comparison->post2_post_id .'/sharedposts', [], $token)->getDecodedBody();
        $second['shared'] = count($shared2['data']);
        $comments2 = $fb->sendRequest('get', '/'. $comparison->post2_post_id .'/comments', [], $token)->getDecodedBody();
        $second['comments'] = count($comments2['data']);

        return response()->json([
            'post1' => [
                'name' => $comparison->post1_page_name,
                'data' => array_values($first)
            ],
            'post2' => [
                'name' => $comparison->post2_page_name,
                'data' => array_values($second)
            ],
        ]);

    }
}
