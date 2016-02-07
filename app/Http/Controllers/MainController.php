<?php
namespace App\Http\Controllers;
use App\Comparison;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;

class MainController extends Controller
{
    protected $fb;
    public function __construct(LaravelFacebookSdk $fb)
    {
        $this->fb = $fb;
    }

    /**
     * @description Main form view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('app.main_form');
    }

    /**
     * @description Get groups/pages information from user fb
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function getDataFromFB(Request $request)
    {
        $token = $request->session()->get('fb_user_access_token');
        $groupsManaged = $this->fb->sendRequest('get', '/me/groups', ['limit' => 100], $token)->getBody();
        $pagesLiked = $this->fb->sendRequest('get', '/me/likes', ['limit' => 100], $token)->getBody();

        return response()->json(['groups' => json_decode($groupsManaged), 'pages' => json_decode($pagesLiked)]);
    }

    /**
     * @description Post data customized by user
     * @param Request $request
     * @return Comparison $comparison
     */
    public function postByUserSelected(Request $request) {
        $post1_image = $post2_image = '';
        $token = $request->session()->get('fb_user_access_token');
        $input = array_except($request->all(), ['_token', 'typeToPost', 'post1_image', 'post2_image']);
        if($request->hasFile('post1_image')){
            $post1_image = $this->upload($request->file('post1_image'));
        }
        if($request->hasFile('post2_image')){
//            $post2_image = $this->upload($request->file('post2_image'));
        }
         // POST text sent by client to respect groups
        $post1_post_id = $this->fb->sendRequest(
            'post',
            '/' . $input['post1_page_id'] . '/feed',
            ['message' => $input['post1_text']],
            $token
        )->getBody();
        /**
         * UPLOAD **
         */
//        $post1_post_id = $this->fb->sendRequest(
//            'post',
//            '/' . $input['post1_page_id'] . '/photos',
//            ['source' => $this->fb->fileToUpload(asset('uploads/'. $post1_image->getFileName()))],
//            $token
//        )->getBody();
        $post1_post_id = json_decode($post1_post_id);
        $input['post1_post_id'] = $post1_post_id->id;
        //
        $post2_post_id = $this->fb->sendRequest(
            'post',
            '/' . $input['post2_page_id'] . '/feed',
            ['message' => $input['post2_text']],
            $token
        )->getBody();
        $post2_post_id = json_decode($post2_post_id);
        $input['post2_post_id'] = $post2_post_id->id;
        //
        $input['user_id'] = $request->session()->get('logged_in');
        $comparison = Comparison::create($input);

        return redirect()->to('/comparison/'. $comparison->id);
    }

    private function upload($image) {
        $validate = Validator::make(['image' => $image], ['image' => 'required']);
        if(!$validate->fails() ) {
            if($image->isValid()) {
                try {
                    $destinationPath = public_path('uploads');
                    $extension = $image->getClientOriginalExtension(); // getting image extension
                    $fileName = time().'_'.md5($image->getClientOriginalName()).'.'.$extension; // renameing image
                    $file = $image->move($destinationPath, $fileName); // uploading file to given path
                    return $file;
                } catch(Exception $e) {
                    dd($e);
                }
            }
        }
        else {
            dd('bad');
        }
    }

}
