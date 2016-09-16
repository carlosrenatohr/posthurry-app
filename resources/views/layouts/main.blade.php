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
        .divider {
            height: 1px;
            width:100%;
            display:block; /* for use on default inline elements like span */
            margin: 9px 0;
            overflow: hidden;
            background-color: #e5e5e5;
        }
        .bg-info {
            background-color: #d9edf7;
        }
        .bg-primary, .bg-info{
            padding: 15px;
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
        $(function() {
            $(".navbar-toggle").click(function (e) {
                $(".naving").css("visibility", "visible");
                $(".naving ul").addClass("ulactive");
                $(".naving ul").removeClass("ulinactive");
            });

            $(".ofer a").click(function (e) {
                $(".limitoff").css("visibility", "visible");
            });

            $(".closed2").click(function (e) {
                $(".limitoff").css("visibility", "hidden");
            });

            $(".closed").click(function (e) {
                $(".naving").css("visibility", "hidden");
                $(".naving ul").removeClass("ulactive");
                $(".naving ul").addClass("ulinactive");
            });

            $('.fb-signup-btn').on('click', function (e) {
                e.preventDefault();
                $.ajax({
                    url: '/gettingUrl',
                    data: {'toReturn': 'signup'},
                    method: 'post',
                    dataType: 'json',
                    success: function (data) {
                        window.location.href = data.url;
                    }
                });
            });

            $(".monthly-payment-button").on('click', function () {
                $(".monthly-payment-form").submit();
            });

            $(".yearly-payment-button").on('click', function () {
                $(".yearly-payment-form").submit();
            });

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

            $('#scheduleBtn').on('click', function(e){
//                $('#blastingTimeContainer').toggleClass('hide');
                $('#blastingTimeContainer').fadeToggle(800, 'linear');
            });

            $('#relogin').on('click', function(e) {
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
                @if(!Session::has('fb_user_access_token') && !Session::has('logged_in'))
                <ul>
                    <div class="closed">X</div>
                    <li><a href="#" class="fb-signup-btn">login</a></li>
                    {{--<li><a href="#" class="fb-signup-btn">signup</a></li>--}}
                </ul>
                @else
                    @if(Session::has('fb_user_access_token'))
                    <?php $user = json_decode(session('fb_user_data')); ?>
                    <ul>
                        <div class="closed">X</div>
                        <li class="pull-right"><a href="{{ url('/logout') }}">logout</a></li>
                        <div class="clearfix"></div>
                        <li style="margin: 10px 0;">Logged in as <b style="font-weight: 800;">{{ ($user->name) }}</b></li>
                    </ul>
                    @else
                        <ul>
                            <div class="closed">X</div>
                            <li><a href="#" class="fb-signup-btn">login</a></li>
                            {{--<li><a href="#" class="fb-signup-btn">signup</a></li>--}}
                        </ul>
                    @endif
                @endif
            </div>
        </div>
    </div>

    @if(Session::has('fb_user_access_token') && Session::has('logged_in'))
    <nav>
        <div class="container">
            <ul class="nav navbar-nav">
                <div class="visible-xs"></div>
                <li class="{{ (Request::is('blasting')) ? 'active' : '' }}"><a
                            href="/blasting">Blast</a></li>
                <li class="{{ (Request::is('blasting-posts')) ? 'active' : '' }}"><a
                            href="/blasting-posts">Blast History</a></li>
                <li class="{{ (Request::is('posting')) ? 'active' : '' }}"><a
                            href="/posting">A/B Contest</a></li>
                <li class="{{ (Request::is('comparison')) ? 'active' : '' }}"><a
                            href="{{ url('comparison') }}">A/B History</a></li>
                <li class="{{ Request::is('comparison/winners') ? 'active' : '' }}"><a
                            href="{{ url('comparison/winners') }}">Winners</a></li>
            </ul>
            @if (Session::has('permissions_required'))
                <button type="button" class="btn btn-danger popover-btn pull-right" data-container="body" data-toggle="popover"
                        data-placement="left" data-title="Grant permissions required" data-active="no" id="granted-btn"
                        data-content="It's required for your correct use of site to grant missing permissions: {!! session('permissions_required') !!}"
                        tabindex="0" data-trigger="focus">
                    <i class="fa fa-remove"></i> Not Granted!</button>
                <button class="btn btn-default" id="relogin">Authorize!</button>
            @else
                <button href="#" class="btn btn-success popover-btn pull-right" id="granted-btn" data-active="yes"
                        data-container="body" data-toggle="popover"
                        data-placement="left" data-title="Grant permissions"
                        data-content="You have granted required permissions, ready to enjoy our service."
                        tabindex="0" data-trigger="focus">
                    <i class="fa fa-check"></i> Facebook Authorizaton Granted!</button>
            @endif
        </div>
    </nav>
    @endif

    {{-- |==> MAIN CONTENT <==|| --}}
    <div class="main-container">
        @if(Session::has('success-msg'))
            <div class="alert alert-success messages">
                {{  session('success-msg') }}
            </div>
        @endif
        @if(Session::has('error-msg'))
            <div class="alert alert-danger messages">
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