<?php
namespace App\Http\Controllers;
use App\Comparison;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;
use App\Library\Helpers\MediaHelper;
//use App\Library\Repositories\PostsPerDayRepository;

class MainController extends Controller
{
    protected $fb, $postsPerDay;
    public function __construct(LaravelFacebookSdk $fb, \App\Library\Repositories\PostsPerDayRepository $postperday)
    {
        $this->fb = $fb;
        $this->postsPerDay = $postperday;
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
        $newGroups = $newPages = [];
        $token = $request->session()->get('fb_user_access_token');
        // -- Getting groups
        $groupsManaged = $this->fb->sendRequest('get', '/me/groups', ['limit' => 500], $token)->getBody();
        $decodingGroups = json_decode($groupsManaged);
        foreach($decodingGroups->data as $group) {
//            $group->label = $group->name. ' (' . $group->_privacy . ')';
            if ($group->privacy == 'OPEN') {
                $newGroups[] = $group;
            }
        }
        // -- Getting pages where user has access
        $accounts = $this->fb->sendRequest('get', '/me/accounts', ['limit' => 100], $token);
//        $pagesIsAdmin = array_pluck(json_decode($accounts)->data, 'id');
        $feed = $accounts->getGraphEdge();
        while(!is_null($feed)) {
            foreach($feed as $status) {
                $page = ($status->asArray());
                    $newPages[] = $page;
            }
            $feed = $this->fb->next($feed);
        }
        // -- Setting pages and groups as response
        $newGroups = ['data' => $newGroups];
        $newPages = ['data' => $newPages];
        $allPagesGot = ['groups' => ($newGroups), 'pages' => $newPages];

        return response()->json($allPagesGot);
    }

    /**
     * @description Post data customized by user
     * @param Request $request
     * @return Comparison $comparison
     */
    public function postByUserSelected(Request $request) {
        if (!$this->postsPerDay->limitPerDayIsOver(Auth::user()->id)) {

            $a_entry = $this->createComparisonEntry( $request, 'post1' );
            $b_entry = $this->createComparisonEntry( $request, 'post2' );

            $entry              = $a_entry + $b_entry;
            $entry['user_id']   = Auth::user()->id;
            
            $comparison         = Comparison::create( $entry );
            
            // Adding a post to register per day
            $this->postsPerDay->sumPost(Auth::user()->id);

            // Multiple groups/pages selected by user to post after comparison
            if ($request->has('blastMassChkbox')) {
                foreach( $request->get( 'massPosts' ) as $type => $item ) {
                    $this->createMassPostsSchedule( $comparison, $request, $type, $item );
                }
            }

            // REDIRECTING...
            if (!is_null($comparison)) {
                return redirect()->to('/comparison/'. $comparison->id);
            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->back()->with('error-msg', "You have exceeded the limit of posts per day.");
        }
    }

    public function getInput( $request ) {
        return array_except($request->all(),
                ['_token', 'typeToPost', 'post1_image', 'post2_image',
                    'blastMassChkbox', 'pagesNamesSelected', 'groupsNamesSelected',
                    'blastDatetime']);
    }

    public function createComparisonEntry( $request, $label ) {
        $input = $this->getInput( $request );
        
        $params[ 'message' ] = $input[ $label . '_text' ];

        $image      = $this->imageHandler( $request, $label );
        $has_image  = false;

        if( $image && is_array( $image ) ) {
            $params[ 'source' ]  = $image[ 'source' ]; 
            $has_image           = true;
        }

        $post_id = $this->postToFb( $input, $label, $params, $has_image );

        return $this->getDataForComparison( $input, $label, $post_id, $image );
    }

    public function imageHandler( $request, $label ) {
        if( ! $request->hasFile($label . '_image')){
            return false;
        }

        $image[ 'image' ]       = MediaHelper::upload($request->file($label . '_image'));
        $image[ 'source' ]      = $this->fb->fileToUpload(asset('uploads/'. $image->getFileName()));
        $image[ 'image_url' ]   = asset('uploads/'. $image->getFileName());

        return $image;
    }

    public function postToFb( $input, $label, $params, $has_image ) {
        $post = $this->fb->sendRequest(
            'post',
            '/' . $input[ $label . '_page_id'] . '/' . ( $has_image ? 'photos' : 'feed'),
            $params,
            Auth::user()->access_token
        )->getBody();
        
        $data = json_decode( $post );

        return $has_image ? $data->post_id : $data->id;
    }

    public function getDataForComparison( $input, $label, $post_id, $image ) {
        $data = [];
        $data[ $label . '_sort' ] = $input[ $label . '_sort' ];
        $data[ $label . '_page_id' ] = $input[ $label . '_page_id' ];
        $data[ $label . '_page_name' ] = $input[ $label . '_page_name' ];
        $data[ $label . '_post_id' ] =  $post_id;
        $data[ $label . '_text' ] = $input[ $label . '_text' ]; 
        $data[ $label . '_img_url' ] = ( is_array( $image ) ) ? $image[ 'image_url' ] : '';

       return $data; 
    }

    public function createMassPostsSchedule( $request, $type, $item ) {
        $named = $this->getNamedSelected( $request );
        foreach( $item as $key => $id ) {
            $data[ $type ]            = $id;
            $data[ $type . '_names' ] = @$named[ $type ][ $key ];
            $data['blastAt']          = $this->convertToServerTimezone( $request->get( 'blastDateTime' ), $key );

            $comparison->massPosts()->save(
                \App\MassPost::create( $data )
            );
        } 
    }

    public function getNamedSelected( $request ) {
        $named[ 'groups' ] = $this->parsingNamedSelected( $request[ 'pagesNamesSelected' ] );
        $named[ 'pages' ] = $this->parsingNamedSelected( $request[ 'groupsNamesSelected' ] );
    }

    public function parsingNamedSelected( $string ) {
        return explode( ',', $string );
    }

    public function convertToServerTimezone( $dateTime, $count ) {
        $userTimezones = Auth::user()->timezones;
        $date          = explode( '-', $dateTime );
        $formattedDate = $date[ 1 ] . '-' . $date[ 0 ] . '-' . $date[ 2 ]; 
        $time          = new \Carbon\Carbon( $formattedDate );

        if( $userTimezones < 0 ) {
            $time->addHours( $userTimezones * -1 );
        }

        else {
            $time->subHours( $userTimezones );
        }

        if( $count > 0 ) {
            $time->addMinutes( ( $count + 1 ) * 6 ); 
        }

        // because it's like server are on utc - 5
        $time->subHours( 5 );

        return $time;
    }

}
