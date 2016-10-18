<?php
/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 10-14-16
 * Time: 11:40 PM
 */
namespace App\Library\Repositories;
use App\Blasting;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;
use App\Library\Helpers\MediaHelper;
use Carbon\Carbon;

class BlastingRepository
{

    protected $blasting, $fb, $postsPerDay;
    public function __construct(Blasting $model, LaravelFacebookSdk $fb, PostsPerDayRepository $postsPerDay)
    {
        $this->blasting = $model;
        $this->fb = $fb;
        $this->postsPerDay = $postsPerDay;
    }

    public function startBlastOut($massGroup, $token, $request = null)
    {
        // Uploading image
        list( $post_has_image, $post_img_url ) = $this->imageHandler($request);

        foreach ($this->getAllPages($massGroup) as $count => $row) {
            // set time to scheduller. 
            // first messages are post directly, so it was now()
            // second and next messages are post for interval 6 minutes
            $params[ 'blastAt' ] = $this->getBlastSchedulerTime($count);

            // set the messages
            $params[ 'message' ] = $request->get('post1_text') . "\n\n[{$count}]";

            // set groups or pages id
            if($row[ 'type' ] == 'page' ) {
                $params[ 'pages_id' ]       = $row[ 'id' ];
                $params[ 'pages_name' ]     = $this->getPagesName( $count, $request );
                $params[ 'groups_id' ]      = "";
                $params[ 'groups_name' ]    = "";
            } else {
                $params[ 'pages_id' ]       = "";
                $params[ 'pages_name' ]     = "";
                $params[ 'groups_id' ]      = $row[ 'id' ];
                $params[ 'groups_name' ]    = $this->getGroupsName( $count, $request );
            }
            
            // Adding new row on blasting table
            $this->blasting->create(
                [
                'post_text' => $request->get('post1_text'),
                'post_img_url' => $post_img_url,
                'groups_id' => $params[ 'groups_id' ], 
                'pages_id' => $params[ 'pages_id' ],
                'user_id' => \Auth::user()->id,
                'blastAt' => $params[ 'blastAt' ],
                'status' => 'waiting'
                ]
            );
        }
    }

    public function imageHandler( $request ) 
    {
        $post_has_image = false;
        $post_img_url = null;
        if($request->hasFile('post1_image')) {
            $post1_image = MediaHelper::upload($request->file('post1_image'));
            $post_has_image = true;
            $params1['source'] = $this->fb->fileToUpload(asset('uploads/'. $post1_image->getFileName()));
            $post_img_url = asset('uploads/'. $post1_image->getFileName());
        }

        return array( $post_has_image, $post_img_url );
    }

    public function getAllPages( $massGroup ) 
    {
        $groups = !empty($massGroup['groups']) ? ($massGroup['groups']) : [];
        $pages = !empty($massGroup['pages']) ? ($massGroup['pages']) : [];
        foreach($groups as $group) {
            $all_pages_selected[] = [
                'id' => $group,
                'type' => 'group'
            ];
        }
        foreach($pages as $page) {
            $all_pages_selected[] = [
                'id' => $page,
                'type' => 'page'
            ];
        }

        return $all_pages_selected;
    }

    protected function getPagesName( $count, $request ) {
        $names = $this->doExploding( $request->get( 'pagesNamesSelected' );

        return $names[ $count ];
    }

    protected function getGroupsName( $count, $request ) {
        $names = $this->doExploding( $request->get( 'groupsNamesSelected' );

        return $names[ $count ];
    }

    protected function doExploding( $names ) {
        return explode( '_,PH//', $names );
    }

    /**
     * get time to blast on scheduler
     * first blast are direct time, now()
     * second and next messages are increment by 6 minutes
     *
     * @param int $count index of groups
     *
     * @return string Carbon
     */
    public function getBlastSchedulerTime( $count ) 
    {
        if($count == 0 ) {
            return Carbon::now();
        }

        return Carbon::now()->addMinutes($count * 6);
    }

    /**
     * @param $blastingID
     * @param $token
     */
    public function scheduleBlastOut($blastingID, $token) 
    {
        $blasting = $this->blasting->find($blastingID);
        $user_id = $blasting->user->id;
        if (!$this->postsPerDay->limitPerDayIsOver($user_id) && $blasting->isToday) {
            $post_has_image = false;
            if (!is_null($blasting->post_img_url)) {
                $post_img_url = $blasting->post_img_url;
                $post_has_image = true;
            }
            // POSTING on fb
            $toPost = array_merge(explode('\,/', $blasting->groups_id), explode('\,/', $blasting->pages_id));
            foreach ($toPost as $count => $id) {
                $bottom = $count . '-' . time();
                $params['message'] = $blasting->post_text . "\n\n[{$bottom}]";
                if ($post_has_image) {
                    $params['source'] = $this->fb->fileToUpload($post_img_url);
                }
                $this->postOnFb($params, $id, $token, $post_has_image);
                $this->postsPerDay->sumPost($user_id);
            }
        }
    }

    /**
     * @param $params
     * @param $fbId
     * @param $token
     * @param bool   $hasImage
     * @return mixed
     */
    private function postOnFb($params, $fbId, $token, $hasImage = false) 
    {
        $request = $this->fb->sendRequest(
            'post',
            '/' . $fbId . '/' . ($hasImage ? 'photos' : 'feed'),
            $params,
            $token
        )->getBody();
        return json_decode($request);
    }
}
