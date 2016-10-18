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
    public function __construct( LaravelFacebookSdk $fb )
    {
        parent::__construct();

        $this->fb = $fb;
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
                    $hasImage = $this->hasImage( $post );

                    $this->info( 'ready to post to fb for id ' . $post->id );
                    $post_return = $this->postOnFb( $params, $fbId, $token, $hasImage );

                    $this->updateBlastingStatus( $post, $post_return );
                }
            }
        }

        $this->info( 'end to blast' );
    }

    /**
     * Get data from table blast where status are waiting and correct blast time
     *
     * return Blasting 
     */
    public function getBlastingList() {
        return Blasting::where( 'status', 'waiting' )->where( 'blastAt', '<=', Carbon::now() )->get();
    }

    /**
     * Get params for facebook post need
     *
     * @param array $post
     *
     * @return array $params
     */ 
    public function getParams( $post ) {
        $params = [];
        $params[ 'message' ] = $post->post_text;

        if( $this->hasImage( $post ) ) { 
            $params[ 'source' ]  = $this->fb->fileToUpload( $post->post_img_url );
        }

        return $params;
    }

    /**
     * Getting Pages or Groups ID for sending fb post
     *
     * @param array $post
     *
     * @return int $fbid
     */
    public function getFbId( $post ) {
        if( ! empty( trim( $post->pages_id ) ) ) {
            return $post->pages_id;                
        }  

        return $post->groups_id;
    }

    /**
     * check if has image or not
     *
     * @param array $post 
     *
     * @return bool
     */
    public function hasImage( $post ) {
        return ( ! empty( $post->post_img_url ) ) ? true : false;
    }

    /**
     * check if post are for page purpose or not
     *
     * @param array $post
     *
     * @return bool
     */
    public function isForPage( $post ) {
        if( empty( $post->pages_id ) ) {
            return false;
        }

        return true;
    }

    /**
     * getting user token at table user
     *
     * @param array $post
     *
     * @return string|bool $access_token
     */
    public function getUserToken( $post ) {
        $user = User::find( $post->user_id );
        if( !empty( $user ) ) {
            return $user->access_token; 
        }

        return false;
    }

    /**
     * send request to post at FB
     *
     * @param array  $params
     * @param int    $fbId
     * @param string $token
     * @param bool   $hasImage
     *
     * @return mixed $request
     */ 
    private function postOnFb($params, $fbId, $token, $hasImage = false) {
        $request = $this->fb->sendRequest(
            'post',
            '/' . $fbId . '/' . ($hasImage ? 'photos' : 'feed'),
            $params,
            $token
        )->getBody();
        return json_decode($request);
    }

    /**
     * update status at blasting page so it doesn't posted again in future
     *
     * @param array $post
     * @param mixed $post_return
     */
    public function updateBlastingStatus( $post, $postReturn ) {
        $postType = ( $this->isForPage( $post ) ) ? 'pages' : 'groups';
        
        $data = [];
        $data[ 'status' ] = 'done';
        $data[ $postType . '_published_id' ] = ( $this->hasImage( $post ) ) ? $postReturn->post_id : $postReturn->id;

        Blasting::where( 'id', $post->id )->update( $data );
    }
}
