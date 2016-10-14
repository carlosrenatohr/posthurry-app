<?php
/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 10-06-16
 * Time: 11:05 AM
 */

namespace App\Library\Repositories;
use \Log;
use \App\PostsPerDay;
use \App\User;

class PostsPerDayRepository
{
    public $postsPerDay;

    public function __construct(PostsPerDay $model)
    {
        $this->postsPerDay = $model;
    }

    public function limitPerDayIsOver($user_id) {
        $this->hasPostToday($user_id);
        return (User::find($user_id)->postsPerDay->posts) > 200;
    }

    public function sumPost($user_id) {
        Log::info( 'user-id-postperday-' . $user_id );
        $this->hasPostToday($user_id);
        $query = $this->postsPerDay->where('user_id', $user_id)->where('today', date('Y-m-d'));

        Log::info( 'user-id-postperday-data', [ 'data' => $query->first() ] );
        $total = $query->first()->posts;
        $query->update([
            'posts' => $total + 1
        ]);
    }

    public function createOrUpdatePostsPerDay($user_id, $addUp = null) {
        $query = $this->postsPerDay->where('user_id', $user_id);
        if ($query->count() > 0) {
//            $query->update(['active' => false]);
            $query->update([
                'today' => date('Y-m-d'),
                'posts' => 0,
                'active' => true,
            ]);
        } else {
            $this->postsPerDay->create([
                'user_id' => $user_id,
                'today' => date('Y-m-d'),
                'posts' => 0,
                'active' => true,
            ]);
        }
    }

    private function hasPostToday($user_id) {
        $query = $this->postsPerDay->where('user_id', $user_id);
        if ($query->count() <= 0) {
            $this->postsPerDay->create([
                'user_id' => $user_id,
                'today' => date('Y-m-d'),
                'posts' => 0,
                'active' => true,
            ]);
        }
    }

}
