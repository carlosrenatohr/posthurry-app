<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    /**
     * @DEPRECATED
     * Fb routes
     */
    // Generate a login URL
    Route::match(['get', 'post'], '/login', function(SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb)
    {
        // Send an array of permissions to request
        $login_url = $fb->getLoginUrl();
        // Obviously you'd do this in blade :)
        echo '<a href="' . $login_url . '">Login with Facebook</a>';
    });
    // Endpoint that is redirected to after an authentication attempt
    Route::get('/facebook/callback', function()
    {
        return redirect('/')->with('message', 'Successfully logged in with Facebook');
    });
    /**
     * Main actions routes
     */
    Route::match(['get', 'post'], '/', 'MainController@index'); //->middleware(['fb.token']);
    Route::post('/data', 'MainController@getDataFromFB')->middleware(['fb.token', 'fb.user']);
    Route::post('/receiveData', 'MainController@postByUserSelected')->name('postData');
    /**
     * Comparison routes
     */
    Route::group(['prefix' => 'comparison', 'middleware' => 'isLoggedIn'], function(){
        Route::get('/', 'ComparisonController@index');
        Route::get('/winners', 'ComparisonController@getWinners');
        Route::get('/{id}', 'ComparisonController@show');
        Route::post('/stats/{id}', 'ComparisonController@postStatsFromFb');
    });

    Route::get('/privacy', function() {
        return view('layouts.privacy-policy');
    });

    Route::get('/faq', function() {
        return view('layouts.faq');
    });

    Route::get('/terms', function() {
        return view('layouts.terms');
    });
});

