<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{!!csrf_token()!!}">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Raleway:400,500,700" />
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
    <meta name="author" content="Syed Ammar Haider Rizvi">
    {{--CSS--}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    {{-- new main page --}}
    <link rel="stylesheet" href="{{ asset('css/mainpage.css') }}">
    <style>
        .header2 {
            overflow: hidden;
            background-color: #2b4170;
            background: -moz-linear-gradient(top, #3b5998, #2b4170);
            background: -ms-linear-gradient(top, #3b5998, #2b4170);
            background: -webkit-linear-gradient(top, #3b5998, #2b4170);
            border: 1px solid #2b4170;
            text-shadow: 0 -1px -1px #1f2f52;
        }
        .footer .item a{
            color: #ffffff!important;
        }
        .footer .item {
            color: #ffffff;
            display: inline-block;
            /*margin: 15px 10px 0 0;*/
            margin: 15px 0 10px 0;
            padding: 5px 10px;
            text-align: center;
        }

        .user-data-space {
            position: absolute;
            top:0;
            right:0;
            max-width: 250px;
        }
        .logo-container {
            position: relative;
            border: 2px gray solid;
            overflow: hidden;
            max-width: 125px;
            max-height: 80px;
            left: 25%;
        }
        #logo-picture {
            width: 100%;
        }
        .text-container {
            max-width: 200px;
        }
        .text-container p {
            color: #FFF;
            text-align: center;
        }

        .navbar-nav li.active {
            background-color: #f5f5f5;
        }
    </style>
    @yield('others-css')
    {{--JS--}}
    <script src="{{ asset('js/all.js') }}"></script>
    @yield('others-js')
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-82146887-1', 'auto');
        ga('send', 'pageview');
        //
        $(function(){
            $('.popover-btn').popover();
            if ($('#granted-btn').data('active') == 'no') {
//                $('.submit-btn').prop('disabled', true);
                $('.submit-btn').on('click', function(e){
                    e.preventDefault();
                    $('html, body').animate({ scrollTop: 0 }, 'fast');
                    alertify.set('notifier','position', 'top-right');
                    alertify.warning('Please check status of granted permissions on button!');
                })
            }
            $('#relogin').on('click', function(e){
                e.preventDefault();
//                window.fbAsyncInit = function() {
                    FB.init({
                        appId: '353859614689535',
                        xfbml: true,
                        version: 'v2.0',
                        cookie: true,
                        status: true
                    });

                    FB.login(function(response) {
                        // Original FB.login code
//                        console.log(response);
                        window.location.reload();
                    }, { auth_type: 'rerequest', scope: "<?php echo session('permissions_required'); ?>", default_audience: 'everyone' });

//                }
            });
            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {return;}
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        });
    </script>
    <title>POST HURRY @yield('pageTitle', '')</title>
</head>
<body style="height:100%;width:100%;padding:0;margin:0">
<div>
    {{-- |==> HEADER <==|| --}}
    <div class="container-fluid newsty">
        <div class="container">
            <header>
                <div class="logosec">
                    <span><a href="/"><img src="{{ asset('img/logo-new.png') }}" alt="logo"/></a><br>When time is money, use PostHurry!</span>
                    <button aria-expanded="false" data-target="#bs-example-navbar-collapse-1" data-toggle="collapse"
                            class="navbar-toggle collapsed" type="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
            </header>
            <div class="naving">
                {{--<ul>--}}
                {{--<div class="closed">X</div>--}}
                {{--<li><a href="#">login</a></li>--}}
                {{--</ul>--}}
                @if(Session::has('fb_user_access_token'))
                    <?php $user = json_decode(session('fb_user_data')); ?>
                    <div style="position: absolute;right: 2%;max-width: 250px;">
                        Logged in as <br> <span style="font-weight:600;">{{ ($user->name) }}</span>
                        <a href="{{ url('/logout') }}" class="fb-logout-btn">Logout</a>
                    </div>
                @else
                    <button class="fb-login-btn">Login</button>
                @endif
            </div>
        </div>
    </div>
    @if(Session::has('fb_user_access_token'))
    <div class="navbar-header" > {{-- background-color: #2B416D --}}
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false"
                style="background-color: lightgray!important;">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar" style="background-color: #222;"></span>
            <span class="icon-bar" style="background-color: #222;"></span>
            <span class="icon-bar" style="background-color: #222;"></span>
        </button>
    </div>
    {{-- Collect the nav links, forms, and other content for toggling style="background-color: #2B416D"--}}
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
            <li class="{{ (Request::is('blasting')) ? 'active' : '' }}"><a
                        href="/blasting">Blast</a></li>
            <li class="{{ (Request::is('blasting-posts')) ? 'active' : '' }}"><a
                        href="/blasting-posts">Blast posts</a></li>
            <li class="{{ (Request::is('posting') or Request::is('posting/*')) ? 'active' : '' }}"><a
                        href="/posting">A/B comparison</a></li>
            <li class="{{ (Request::is('comparison') or Request::is('comparison/*')) ? 'active' : '' }}"><a
                        href="{{ url('comparison') }}">Comparisons</a></li>
            <li class="{{ Request::is('/comparison/winners') ? 'active' : '' }}"><a
                        href="{{ url('/comparison/winners') }}">Winners</a></li>
            <div class="granted-btns-container" style="position: absolute;right: 5%;margin-top: 0.5em;">
                @if (Session::has('permissions_required'))
                    <button type="button" class="btn btn-danger popover-btn" data-container="body" data-toggle="popover"
                            data-placement="left" data-title="Grant permissions required" data-active="no" id="granted-btn"
                            data-content="It's required for your correct use of site to grant missing permissions: {!! session('permissions_required') !!}"
                            tabindex="0" data-trigger="focus">
                        <i class="fa fa-remove"></i> Not Granted!</button>
                    <button class="btn btn-default" id="relogin">Authorize!</button>
                @else
                    <button href="#" class="btn btn-success popover-btn" id="granted-btn" data-active="yes"
                            data-container="body" data-toggle="popover"
                            data-placement="left" data-title="Grant permissions"
                            data-content="You have granted required permissions, ready to enjoy our service."
                            tabindex="0" data-trigger="focus">
                        <i class="fa fa-check"></i> Granted!</button>
                @endif
            </div>
        </ul>
    </div><!-- /.navbar-collapse -->
    @endif

    {{-- |==> MAIN CONTENT <==|| --}}
    <div class="main-container">
        @if(Session::has('success-msg'))
            <div class="alert alert-success messages">
                {{  session('success-msg') }}
            </div>
        @endif
        @if(Session::has('error-msg'))
            <div class="alert alert-error messages">
                {{  session('error-msg') }}
            </div>
        @endif
        <div class="container-fluid">
            <img src="{{ asset('img/loading.gif') }}" alt="" class="img-responsive img-loading hide"
                 style="max-width: 150px;position: absolute;right: 0;">
            @yield('content')
        </div>
        {{ Form::hidden('fb_scopes', implode(',', config('laravel-facebook-sdk.default_scope')), ['id' => 'fb_scopes']) }}
    </div>
</div>

{{-- |==> FOOTER <==|| --}}
<div class="container-fluid foot">
    <div class="container">
        <div class="col-lg-6 col-md-6 copyleft">
            <a href="{{ url('faq') }}">FAQ</a>
            <a href="{{ url('privacy') }}">Privacy Policy</a>
            <a href="{{ url('terms') }}">Terms of Service</a>
        </div>
        <div class="col-lg-6 col-md-6 copyright">
            Copyright @ 2016 PostHurry
        </div>
    </div>
</div>
</body>
</html>