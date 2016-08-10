<?php
/**
 * Created by PhpStorm.
 * User: carlosrenato
 * Date: 08-10-16
 * Time: 11:52 AM
 */
namespace App\Library\Helpers;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;

class FbHandleHelper
{
    protected $fb;

    public function __construct(LaravelFacebookSdk $fb)
    {
        $this->fb = $fb;
    }

    public function permissionsGranted() {
        $token = session('fb_user_access_token');
        $permissions = $this->fb->sendRequest('get', '/me/permissions', [], $token)->getBody();
        $class = json_decode($permissions);
        return $class->data;
    }

}