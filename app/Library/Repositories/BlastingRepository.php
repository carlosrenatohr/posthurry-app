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
        // Getting pages/posts ids selected by user
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
        // Uploading image
        $post_has_image = false;
        $post_img_url = null;
        if($request->hasFile('post1_image')){
            $post1_image = MediaHelper::upload($request->file('post1_image'));
            $post_has_image = true;
            $params1['source'] = $this->fb->fileToUpload(asset('uploads/'. $post1_image->getFileName()));
            $post_img_url = asset('uploads/'. $post1_image->getFileName());
        }
        // POSTING on fb
        $pages__posts_id = $groups__posts_id = [];
        foreach ($all_pages_selected as $count => $row) {
            // set time to scheduller. 
            // first messages are post directly, so it was now()
            // second and next messages are post for interval 6 minutes
            $params[ 'blastAt' ] = $this->getBlastSchedulerTime( $count );
            $params['message'] = $request->get('post1_text') . "\n\n[{$count}]";
            // Execute fileToUpload on every Page to post
            if ($post_has_image)
                $params['source'] = $this->fb->fileToUpload($post_img_url);

            // commmented out, 
            // don;t publish it now, save it at table blasting
            // then the scheduler will post it on there
            // $post_return = $this->postOnFb($params, $row['id'], $token, $post_has_image);
            // $this->postsPerDay->sumPost(\Auth::user()->id);

            // Storing page/group
            if($row['type'] == 'page')
                $pages__posts_id[] = ($post_has_image) ? $post_return->post_id : $post_return->id;
            elseif($row['type'] == 'group')
                $groups__posts_id[] = ($post_has_image) ? $post_return->post_id : $post_return->id;

        $pages__posts_id_string = implode('\,/', $pages__posts_id);
        $groups__posts_id_string = implode('\,/', $groups__posts_id);
        $groups__names = explode('_,PH//', $request->get('groupsNamesSelected'));
        $groups__names__string = implode('\,/', $groups__names);
        $pages__names = explode('_,PH//', $request->get('pagesNamesSelected'));
        $pages__names__string = implode('\,/', $pages__names);

        // Adding new row on blasting table
        $this->blasting->create([
            'post_text' => $request->get('post1_text'),
            'post_img_url' => $post_img_url,
            'groups_id' => implode('\,/', $groups),
            'groups_names' => $groups__names__string,
            'groups_published_id' => $groups__posts_id_string,
            'pages_id' => implode('\,/', $pages),
            'pages_names' => $pages__names__string,
            'pages_published_id' => $pages__posts_id_string,
            'user_id' => \Auth::user()->id,
            'blastAt' => $param[ 'blastAt' ]
        ]);
        }
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
    public function getBlastSchedulerTime( $count ) {
        if( $count == 0 ) {
            return Carbon::now();
        }

        return Carbon::now()->addMinutes( 6 );
    }

    /**
     * @param $blastingID
     * @param $token
     */
    public function scheduleBlastOut($blastingID, $token) {
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
     * @param bool $hasImage
     * @return mixed
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
}
