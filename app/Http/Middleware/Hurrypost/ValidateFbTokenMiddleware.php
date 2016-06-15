<?php

namespace App\Http\Middleware\Hurrypost;

use Closure;
use \SammyK\LaravelFacebookSdk\LaravelFacebookSdk;

class ValidateFbTokenMiddleware
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
        // Obtain an access token.
        try {
//            $token = $this->fb->getAccessTokenFromRedirect();
              $token = $this->fb->getJavaScriptHelper()->getAccessToken();
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            dd($e->getMessage());
        }
        // Access token will be null if the  user denied the request
        // or if someone just hit this URL outside of the OAuth flow.
        if (!$token) {
            // Get the redirect helper
            $helper = $this->fb->getRedirectLoginHelper();
            if (!$helper->getError()) {
                abort(403, 'Unauthorized action.');
            }
            // User denied the request
            dd(
                $helper->getError(),
                $helper->getErrorCode(),
                $helper->getErrorReason(),
                $helper->getErrorDescription()
            );
        }
        if (!$token->isLongLived()) {
            // OAuth 2.0 client handler
            $oauth_client = $this->fb->getOAuth2Client();
            // Extend the access token.
            try {
                $token = $oauth_client->getLongLivedAccessToken($token);
            } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                dd($e->getMessage());
            }
        }
        $this->fb->setDefaultAccessToken($token);
        // Save for later
        $request->session()->put('fb_user_access_token', (string)$token);
//        $request->session()->flash('fb_user_access_token', (string)$token);
        // Get basic info on the user from Facebook.
        try {
            $response = $this->fb->get('/me?fields=id,name,email')->getBody();
            $request->session()->put('fb_user_data', $response);
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            dd($e->getMessage());
        }

        return $next($request);
    }
}
