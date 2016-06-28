<?php
namespace App\Console;
use App\Comparison;
use App\Comparison_data;
use App\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Http\Request;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
            ->hourly();
        $schedule->call(
            function (Request $request, LaravelFacebookSdk $fb) {
                foreach (User::all() as $user) {
                    $token = $user->access_token;
                    foreach ($user->comparisons as $contest) {
                        if ($this->comparisonIsExpired($contest->created_at, $contest->limitDaysDuration)) {
                            $row_saved = $contest->data_row;
                            if (is_null($row_saved)) {
                                $collection = $this->getDetailsFromFB($fb, $contest, $token);
                                $row = new Comparison_data(
                                    [
                                        'post1_likes' => $collection['first']['likes'],
                                        'post1_shares' => $collection['first']['shared'],
                                        'post1_comments' => $collection['first']['comments'],
                                        'post2_likes' => $collection['second']['likes'],
                                        'post2_shares' => $collection['second']['shared'],
                                        'post2_comments' => $collection['second']['comments'],
                                    ]
                                );
                                $contest->data_row()->save($row);
                                $row_saved = $row;
                                // set winner
                            }
                            $winner = $this->setWinnerByComparison($row_saved);
                            $contest->fill(['winner' => $winner])->save();
                            // Blast it out on mass groups selected if was chosen by user
                            if (!is_null($contest->massPosts)) {
                                $blastDate = new \Carbon\Carbon($contest->massPosts->blastAt);
                                $now = \Carbon\Carbon::now();
                                if ($now->gt($blastDate) && is_null($contest->massPosts->posts_published)) {
                                    // If post 1 or was a tie, post 1 will be post in mass, else post 2 will be posted
                                    $winnerNum = ($winner == 1) ? 1 : 2;
                                    $this->publishInMass($contest, $winnerNum, $token, $fb);
                                    var_dump('MASSED ' . date('d-m-Y h:i:s'));
                                }
                            }
                        }
                    }
                }
            }
        )->appendOutputTo('/home/carlosrenato/htdocs/gethurrypost/log.txt')
//            ->everyFiveMinutes();
//        ->hourly();
        ->everyMinute();
    }

    private function comparisonIsExpired($date, $days)
    {
        $limit = new \Carbon\Carbon($date);
        $expiration = $limit->addMinutes($days);
        $now = \Carbon\Carbon::now();
        return $now->gt($expiration);
    }

    private function publishInMass($comparison, $numberOfWinnerPost, $token, $fb)
    {
        $post = 'post' . $numberOfWinnerPost;
        $post_has_image = false;
        $params = array(
            'message' => $comparison->{$post . '_text'}
        );
        $msg = $comparison->{$post . '_text'};
        // Getting pages/posts ids selected by user
        $groups = !empty($comparison->massPosts->groups) ? json_decode($comparison->massPosts->groups) : [];
        $pages = !empty($comparison->massPosts->pages) ? json_decode($comparison->massPosts->pages) : [];
        $all_pages_selected = array_merge($groups, $pages);
        // POSTING on fb
        $posts_id = [];
        foreach ($all_pages_selected as $count => $page_id) {
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

    private function getDetailsFromFB($fb, $comparison, $token)
    {
        $first = $second = [];
        // First post
        $likes1 = $fb->sendRequest('get', '/' . $comparison->post1_post_id . '/likes', [], $token)->getDecodedBody();
        $first['likes'] = count($likes1['data']);
        $shared1 = $fb->sendRequest(
            'get',
            '/' . $comparison->post1_post_id . '/sharedposts',
            [],
            $token
        )->getDecodedBody();
        $first['shared'] = count($shared1['data']);
        $comments1 = $fb->sendRequest(
            'get',
            '/' . $comparison->post1_post_id . '/comments',
            [],
            $token
        )->getDecodedBody();
        $first['comments'] = count($comments1['data']);
        // Second post
        $likes2 = $fb->sendRequest('get', '/' . $comparison->post2_post_id . '/likes', [], $token)->getDecodedBody();
        $second['likes'] = count($likes2['data']);
        $shared2 = $fb->sendRequest(
            'get',
            '/' . $comparison->post2_post_id . '/sharedposts',
            [],
            $token
        )->getDecodedBody();
        $second['shared'] = count($shared2['data']);
        $comments2 = $fb->sendRequest(
            'get',
            '/' . $comparison->post2_post_id . '/comments',
            [],
            $token
        )->getDecodedBody();
        $second['comments'] = count($comments2['data']);
        return [
            'first' => $first,
            'second' => $second,
        ];
    }

    private function setWinnerByComparison($row)
    {
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
        return ($item1 >= $item2) ? 1 : 2;
    }
}
