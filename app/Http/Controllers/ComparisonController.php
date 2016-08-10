<?php
namespace App\Http\Controllers;
use App\Comparison;
use App\Comparison_data;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Library\Helpers\MediaHelper;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;

class ComparisonController extends Controller
{
    protected $comparison, $fb;

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
        $isExpired = MediaHelper::comparisonIsExpired($comparison->created_at, $comparison->limitDaysDuration);
//        $isExpired = $this->comparisonIsExpired($comparison->created_at, $comparison->limitDaysDuration);
        return view('comparison.show', ['comparison' => $comparison, 'isExpired' => $isExpired]);
    }


    public function getWinners(Request $request) {
        $user_id = $request->session()->get('logged_in');
        $winners = $this->comparison->where('user_id', $user_id)->whereNotNull('winner')->get();
        return view('comparison.winners', ['comparison' => $winners]);
    }

    public function postStatsFromFb($id, Request $request, LaravelFacebookSdk $fb)
    {
        $comparison = $this->comparison->find($id);
        $token = $request->session()->get('fb_user_access_token');
        // Validation. If time of compare is expired
        if(MediaHelper::comparisonIsExpired($comparison->created_at, $comparison->limitDaysDuration)) {
//        if($this->comparisonIsExpired($comparison->created_at, $comparison->limitDaysDuration)) {
            $row_saved = $comparison->data_row;
            if (!is_null($row_saved)) {
                $collection = [
                    'first' => [
                        'likes' => (int)$row_saved->post1_likes,
                        'shared' => (int)$row_saved->post1_shares,
                        'comments' => (int)$row_saved->post1_comments,
                    ],
                    'second' => [
                        'likes' => (int)$row_saved->post2_likes,
                        'shared' => (int)$row_saved->post2_shares,
                        'comments' => (int)$row_saved->post2_comments,
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
                // set winner
                $winner = $this->setWinnerByComparison($row);
                $comparison->fill(['winner' => $winner])->save();
                // Blast it out on mass groups selected if was chosen by user
//                if (!is_null($comparison->massPosts)) {
                    // If post 1 or was a tie, post 1 will be post in mass, else post 2 will be posted
                    $winnerNum = ($winner == 1) ? 1 : 2;
//                    $this->postInMass($comparison, $winnerNum, $fb, $token);
//                }
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

    private function setWinnerByComparison($row) {
        $item1 = $item2 = 0;
        if ($row->post1_likes > $row->post2_likes) {
            $item1++;
        } elseif ($row->post1_likes < $row->post2_likes) {
            $item2++;
        } else {

        }
        // check shares
        if ($row->post1_shares > $row->post2_shares) {
            $item1++;
        } elseif ($row->post1_shares < $row->post2_shares) {
            $item2++;
        } else {

        }
        // check shares
        if ($row->post1_comments > $row->post2_comments) {
            $item1++;
        } elseif ($row->post1_comments < $row->post2_comments) {
            $item2++;
        } else {

        }

//        return ($item1 > $item2) ? 1 : ($item1 < $item2) ? 2 : 3;
        return ($item1 >= $item2) ? 1 : 2;
    }


    private function postInMass($comparison, $numberOfWinnerPost, $fb, $token) {
        $post = 'post' . $numberOfWinnerPost;
        $post_has_image = false;
        $params = array(
            'message' => $comparison->{$post . '_text'}
        );
        $msg = $comparison->{$post . '_text'};

        // Getting pages/posts ids selected by user
        $groups = !empty($comparison->massPosts->groups) ? json_decode($comparison->massPosts->groups) :  [];
        $pages = !empty($comparison->massPosts->pages) ? json_decode($comparison->massPosts->pages) : [];
        $all_pages_selected = array_merge($groups, $pages);
        // POSTING on fb
        $posts_id = [];
        foreach($all_pages_selected as $count => $page_id) {
            $params['message'] = $msg . "\n\n[{$count}]";
            // Execute fileToUpload on every Page to post
            if (!is_null($comparison->{$post . '_img_url'})) {
                $post_has_image = true;
                $params['source'] = $fb->fileToUpload($comparison->{$post . '_img_url'});
            }
            $post_return = $fb->sendRequest(
                'post',
                '/' . $page_id . '/' . ($post_has_image ? 'photos' : 'feed'),
                $params,
                $token
            )->getBody();

            $post_return = json_decode($post_return);
            $posts_id[] = ($post_has_image) ? $post_return->post_id : $post_return->id;
        }
        $posts_id_string = implode(',', $posts_id);
        $comparison->massPosts->fill(['posts_published' => $posts_id_string])->save();
    }
}
