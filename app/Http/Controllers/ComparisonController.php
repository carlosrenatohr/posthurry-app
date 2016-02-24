<?php
namespace App\Http\Controllers;
use App\Comparison;
use App\Comparison_data;
use App\User;
use Carbon\Carbon;
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
        $isExpired = $this->comparisonIsExpired($comparison->created_at, $comparison->limitDaysDuration);
        return view('comparison.show', ['comparison' => $comparison, 'isExpired' => $isExpired]);
    }

    public function postStatsFromFb($id, Request $request, LaravelFacebookSdk $fb)
    {
        $comparison = $this->comparison->find($id);
        $token = $request->session()->get('fb_user_access_token');
        // Validation. If time of compare is expired
        if($this->comparisonIsExpired($comparison->created_at, $comparison->limitDaysDuration)){
            $row_saved = $comparison->data_row;
            if (!is_null($row_saved)) {
                $collection = [
                    'first' => [
                        'likes' => $row_saved->post1_likes,
                        'shared' => $row_saved->post1_shares,
                        'comments' => $row_saved->post1_comments,
                    ],
                    'second' => [
                        'likes' => $row_saved->post2_likes,
                        'shared' => $row_saved->post2_shares,
                        'comments' => $row_saved->post2_comments,
                    ]
                ];
            } else {
                $collection = $this->getDetailsFromFB($fb, $comparison, $token);
                $row = new Comparison_data([
                   'post1_likes' => $collection['first']['likes'],
                   'post1_shares' => $collection['first']['shared'],
                   'post1_comments' => $collection['first']['comments'],
                    'post2_likes' => $collection['second']['likes'],
                   'post2_shares' => $collection['second']['shared'],
                   'post2_comments' => $collection['second']['comments'],
                ]);
                $comparison->data_row()->save($row);
//                $result = $comparison->data_row;
            }
        } else {
            $collection = $this->getDetailsFromFB($fb, $comparison, $token);
        }


        return response()->json([
            'post1' => [
                'name' => $comparison->post1_page_name,
                'data' => array_values($collection['first'])
            ],
            'post2' => [
                'name' => $comparison->post2_page_name,
                'data' => array_values($collection['second'])
            ],
        ]);

    }

    private function getDetailsFromFB($fb, $comparison, $token) {
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

        return [
            'first' => $first,
            'second' => $second,
        ];
    }

    private function comparisonIsExpired($date, $days) {
        $limit = new \Carbon\Carbon($date);
        $limit = $limit->addDays($days);
        $now = \Carbon\Carbon::now();
        return $limit->gte($now);

    }
}
