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
        $groupsManaged = $this->fb->sendRequest('get', '/me/groups', ['limit' => 500], $token)->getBody();
        $pagesLiked = $this->fb->sendRequest('get', '/me/likes', ['limit' => 500], $token)->getBody();


        $allPagesGot = ['groups' => json_decode($groupsManaged), 'pages' => json_decode($pagesLiked)];

        return response()->json($allPagesGot);
    }

    /**
     * @description Post data customized by user
     * @param Request $request
     * @return Comparison $comparison
     */
    public function postByUserSelected(Request $request) {
        $post1_has_image = $post2_has_image = false;
        $token = $request->session()->get('fb_user_access_token');
        $input = array_except($request->all(),
                    ['_token', 'typeToPost', 'post1_image', 'post2_image', 'blastMassChkbox', 'pagesNamesSelected', 'groupsNamesSelected']);
        if ($request->has('blastMassChkbox')) {
            $blastMass = array_pull($input, 'massPosts');
        }
        // Creating params array for request
        $params1 = array(
            'message' => $input['post1_text']
        );
        $params2 = array(
            'message' => $input['post2_text']
        );
        if($request->hasFile('post1_image')){
            $post1_image = $this->upload($request->file('post1_image'));
            $post1_has_image = true;
            $params1['source'] = $this->fb->fileToUpload(asset('uploads/'. $post1_image->getFileName()));
            $input['post1_img_url'] = asset('uploads/'. $post1_image->getFileName());
        }
        if($request->hasFile('post2_image')){
            $post2_image = $this->upload($request->file('post2_image'));
            $post2_has_image = true;
            $params2['source'] = $this->fb->fileToUpload(asset('uploads/'. $post2_image->getFileName()));
            $input['post2_img_url'] = asset('uploads/'. $post2_image->getFileName());
        }

         // POST text sent by client to respect groups
        /**
         * 1st Post
         */
        $post1_post_id = $this->fb->sendRequest(
            'post',
            '/' . $input['post1_page_id'] . '/' . ($post1_has_image ? 'photos' : 'feed'),
            $params1,
            $token
        )->getBody();

        $post1_post_id = json_decode($post1_post_id);
//        $input['post1_post_id'] = $post1_post_id->id;
        $input['post1_post_id'] = ($post1_has_image) ? $post1_post_id->post_id : $post1_post_id->id;
        /**
         * 2nd Post
         */
        $post2_post_id = $this->fb->sendRequest(
            'post',
            '/' . $input['post2_page_id'] . '/'. ($post2_has_image ? 'photos' : 'feed'),
            $params2,
            $token
        )->getBody();
        $post2_post_id = json_decode($post2_post_id);
        $input['post2_post_id'] = ($post2_has_image) ? $post2_post_id->post_id : $post2_post_id->id;
        // Getting user id to store
        $input['user_id'] = $request->session()->get('logged_in');
        $comparison = Comparison::create($input);
        // Multiple groups/pages selected by user to post after comparison
        if ($request->has('blastMassChkbox')) {
            $blastMassJson = [];
            $blastMassJson['groups'] = json_encode($blastMass['groups'], true);
            $blastMassJson['pages'] = json_encode($blastMass['pages'], true);
            $blastMassJson['pages_names'] = $request->get('pagesNamesSelected');
            $blastMassJson['groups_names'] = $request->get('groupsNamesSelected');

            $massPostRow = \App\MassPost::create($blastMassJson);
            $comparison->massPosts()->save($massPostRow);
        }
        // REDIRECTING...
        if (!is_null($comparison)) {
            return redirect()->to('/comparison/'. $comparison->id);
        } else {
            return redirect()->back();
        }

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
