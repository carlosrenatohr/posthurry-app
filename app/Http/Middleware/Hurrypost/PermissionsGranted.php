<?php

namespace App\Http\Middleware\Hurrypost;

use App\Library\Helpers\FbHandleHelper;
use Closure;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;

class PermissionsGranted
{
    protected $fb;
    public function __construct(LaravelFacebookSdk $fb)
    {
        $this->fb = $fb;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $fb = new FbHandleHelper($this->fb);
        $granted = true;
        $permissionsRequired = [];
        foreach($fb->permissionsGranted() as $permission) {
            if($permission->status == 'declined') {
                $granted = false;
                $permissionsRequired[] = $permission->permission;
            }
        }
        if (!$granted)
            $request->session()->put('permissions_required', implode(',', $permissionsRequired));
        else
            $request->session()->remove('permissions_required');

        return $next($request);
    }
}
