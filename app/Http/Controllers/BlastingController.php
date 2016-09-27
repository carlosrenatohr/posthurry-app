<?php
/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 08-09-16
 * Time: 12:37 AM
 */
namespace App\Http\Controllers;

use App\Blasting;
use App\User;
use App\Library\Helpers\MediaHelper;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;
use Symfony\Component\HttpFoundation\Request;

class BlastingController extends Controller
{

    protected $fb;
    public function __construct(LaravelFacebookSdk $fb)
    {
        $this->fb = $fb;
    }

    public function index(Request $request) {
        $user_id = Auth::user()->id;

        $user = User::find($user_id);
        return view('blasting.index', ['user' => $user]);
    }

    public function getBlastingOutForm( Request $request ) {

        $fb = true;
        if( !$request->session()->has('fb_user_access_token')){
             $fb_login_url = $this->fb->getLoginUrl();
             $request->session()->flash( 'error-msg', 'Connect your Facebook account to view your Groups and Pages. <a href="'.$fb_login_url.'" class="btn btn-primary">Connect with facebook.</a>' );

             $fb = false;
        }

        return view('app.blasting_form', compact('fb'));
;
    }

    /**
     * @description Action to blast posts out in mass
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postBlastingOut(Request $request) {
        $massGroup = $request->get('massPosts');
        $token = $request->session()->get('fb_user_access_token');
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
//            $post1_image = $this->upload($request->file('post1_image'));
            $post_has_image = true;
            $params1['source'] = $this->fb->fileToUpload(asset('uploads/'. $post1_image->getFileName()));
            $post_img_url = asset('uploads/'. $post1_image->getFileName());
        }
        // POSTING on fb
        $pages__posts_id = $groups__posts_id = [];
        foreach ($all_pages_selected as $count => $row) {
            $params['message'] = $request->get('post1_text') . "\n\n[{$count}]";
            // Execute fileToUpload on every Page to post
            if ($post_has_image)
                $params['source'] = $this->fb->fileToUpload($post_img_url);
            $post_return = $this->fb->sendRequest(
                'post',
                '/' . $row['id'] . '/' . ($post_has_image ? 'photos' : 'feed'),
                $params,
                $token
            )->getBody();
            $post_return = json_decode($post_return);
            if($row['type'] == 'page')
                $pages__posts_id[] = ($post_has_image) ? $post_return->post_id : $post_return->id;
            elseif($row['type'] == 'group')
                $groups__posts_id[] = ($post_has_image) ? $post_return->post_id : $post_return->id;
        }
        $pages__posts_id_string = implode('\,/', $pages__posts_id);
        $groups__posts_id_string = implode('\,/', $groups__posts_id);
        $groups__names = explode('_,PH//', $request->get('groupsNamesSelected'));
        $groups__names__string = implode('\,/', $groups__names);
        $pages__names = explode('_,PH//', $request->get('pagesNamesSelected'));
        $pages__names__string = implode('\,/', $pages__names);

        Blasting::create([
            'post_text' => $request->get('post1_text'),
            'post_img_url' => $post_img_url,
            'groups_id' => implode('\,/', $groups),
            'groups_names' => $groups__names__string,
            'groups_published_id' => $groups__posts_id_string,
            'pages_id' => implode('\,/', $pages),
            'pages_names' => $pages__names__string,
            'pages_published_id' => $pages__posts_id_string,
            'user_id' => $request->session()->get('logged_in'),
        ]);

        return redirect('/blasting-posts')->with('success-msg', 'Blasting out your post successfully!');
    }
}
