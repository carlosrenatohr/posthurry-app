<?php

namespace App\Console\Commands;

use App\Blasting;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;

class BlastingOBlasting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blast:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Blast every post each 6 minutes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info( 'start to blast' );

        if( $posts = $this->getBlastingList() ) {
            foreach( $posts as $key => $post ) {
                if( !empty( $post ) && $token = $this->getUserToken( $post ) ) {
                    $params   = $this->getParams( $post );
                    $fbId     = $this->getFbId( $post );
                    $hasImage = ( ! empty( $post->post_img_url ) ) ? true : false;

                    $this->info( 'ready to post to fb for id ' . $post->id );
                    $this->postOnFb( $params, $fbId, $token, $hasImage );
                }
            }
        }

        $this->info( 'end to blast' );
    }

    public function getBlastingList() {
        return Blasting::where( 'status', 'waiting' )->where( 'blastAt', '<=', Carbon::now() )->get();
    }

    public function getParams( $post ) {
        $params = [];
        $params[ 'message' ] = $post->post_text;
        $params[ 'source' ]  = $post->post_img_url;

        return $params;
    }

    public function getFbId( $post ) {
        if( ! empty( trim( $post->pages_id ) ) ) {
            return $post->pages_id;                
        }  

        return $post->groups_id;
    }

    public function getUserToken( $post ) {
        $user = User::find( $post->user_id );
        if( !empty( $user ) ) {
            return $user->access_token; 
        }

        return false;
    }

    private function postOnFb($params, $fbId, $token, $hasImage = false) {
        $request = $this->fb->sendRequest(
            'post',
            '/' . $fbId . '/' . ($hasImage ? 'photos' : 'feed'),
            $params,
            $token
        )->getBody();
        return json_decode($request);
    }
}
