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
     * FB routes
     */
    // Endpoint that is redirected to after an authentication attempt
    Route::get('/facebook/callback', 'AuthController@fbCallback');
    /**
     * Main actions routes
     */
    Route::get('/', 'AccessController@index');
    Route::post('/gettingUrl', 'AccessController@getLoginUrl');
    Route::get('/authenticating', 'AccessController@fbCallback');
    Route::get('/login', 'AccessController@getLogin');
    Route::post('/login', 'AccessController@postLogin');
    Route::get('/signup', 'AccessController@getSignup');
    Route::post('/signup', 'AccessController@postSignup');
    Route::get('/logout', 'AccessController@logout');
//    Route::match(['get', 'post'], '/', 'MainController@index'); //->middleware(['fb.token']);
    Route::post('/data', 'MainController@getDataFromFB'); //->middleware(['fb.user']); //['fb.token', 'fb.user']
    Route::post('/receiveData', 'MainController@postByUserSelected')->name('postData');
    Route::group(['middleware' => ['isLoggedIn']], function () {
        Route::match(['get', 'post'], '/posting', 'MainController@index');
        Route::get('/blasting', 'BlastingController@getBlastingOutForm');
        Route::post('/blastingOut', 'BlastingController@postBlastingOut')->name('postBlasting');
        Route::group(['prefix' => 'blasting-posts'], function () {
            Route::get('/', ['as' => 'blasting-index', 'uses' => 'BlastingController@index']);
        });
    });

    /**
     * Comparison routes
     */
    Route::group(['prefix' => 'comparison', 'middleware' => 'isLoggedIn'], function () {
        Route::get('/', 'ComparisonController@index');
        Route::get('/winners', 'ComparisonController@getWinners');
        Route::get('/{id}', 'ComparisonController@show');
        Route::post('/stats/{id}', 'ComparisonController@postStatsFromFb');
    });

    Route::get('/privacy', function () {
        return view('layouts.privacy-policy');
    });

    Route::get('/faq', function () {
        return view('layouts.faq');
    });

    Route::get('/terms', function () {
        return view('layouts.terms');
    });

    Route::group(['prefix' => 'plans'], function () {
        Route::post('/ipn', ['as' => 'plans.ipn', 'uses' => 'PlansController@postIpn']);
        Route::get('/monthly', ['as' => 'plans.monthly', 'uses' => 'PlansController@getMonthly']);
        Route::get('/yearly', ['as' => 'plans.yearly', 'uses' => 'PlansController@getYearly']);
        Route::get('/trial', ['as' => 'plans.trial', 'uses' => 'PlansController@getTrial']);
        Route::get('/', ['as' => 'plans', 'uses' => 'PlansController@getIndex']);
    });

    Route::get('/temp', function () {
        return view('layouts.new-index');
    });
});

