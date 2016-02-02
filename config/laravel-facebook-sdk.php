<?php
return [
    /*
     * In order to integrate the Facebook SDK into your site,
     * you'll need to create an app on Facebook and enter the
     * app's ID and secret here.
     *
     * Add an app: https://developers.facebook.com/apps
     *
     * You can add additional config options here that are
     * available on the main Facebook\Facebook super service.
     *
     * https://developers.facebook.com/docs/php/Facebook/5.0.0#config
     *
     * Using environment variables is the recommended way of
     * storing your app ID and app secret. Make sure to update
     * your /.env file with your app ID and secret.
     */
//    'facebook_config' => [
//        'app_id' => env('FACEBOOK_APP_ID'),
//        'app_secret' => env('FACEBOOK_APP_SECRET'),
//        'default_graph_version' => 'v2.5',
//        //'enable_beta_mode' => true,
//        //'http_client_handler' => 'guzzle',
//    ],
    /**
     * POST HURRY
     */
    'facebook_config' => [
        'app_id' => '353859614689535',
        'app_secret' => 'ed4e013338b91267bf4c6a43f1d23b3d',
        'default_graph_version' => 'v2.0', // v2.5
        //'enable_beta_mode' => true,
        //'http_client_handler' => 'guzzle',
    ],
    /*
     * The default list of permissions that are
     * requested when authenticating a new user with your app.
     * The fewer, the better! Leaving this empty is the best.
     * You can overwrite this when creating the login link.
     *
     * Example:
     *
     * 'default_scope' => ['email', 'user_birthday'],
     *
     * For a full list of permissions see:
     *
     * https://developers.facebook.com/docs/facebook-login/permissions
     */
    'default_scope' => [
        'email',
        'public_profile',
        'user_groups',
        'publish_pages',
        'user_likes',
        'manage_pages',
//        'pages_show_list',
//        'pages_manage_cta',
        'publish_pages',
        'publish_actions',
    ], //user_managed_groups
    /*
     * The default endpoint that Facebook will redirect to after
     * an authentication attempt.
     */
    'default_redirect_uri' => '/facebook/callback',
];
