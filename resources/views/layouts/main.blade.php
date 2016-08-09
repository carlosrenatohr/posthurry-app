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

    </script>
    <title>POST HURRY @yield('pageTitle', '')</title>
</head>
<body style="height:100%;width:100%;padding:0;margin:0">
<div>
    {{-- |==> FOOTER <==|| --}}
    @if(!isset($withoutHeader))
    <header>
        <div class="col-md-12 header2" style="height:110px;width:100%;">
            <center>
                <div class="" style="margin-top:10px">
                    <div class="pull-left col-md-6 col-sm-5 col-xs-7">
                        <a href="/">
                            <img src="{{ asset('img/logo2.png') }}" class="pull-left"/>
                        </a>
                    </div>
                </div>
            </center>
            {{--@if (Session::has('fb_user_data'))--}}
            {{--<div class="user-data-space">--}}
                {{--<div class="logo-container">--}}
                    {{--<img id="logo-picture" src="https://image.freepik.com/free-icon/male-user-shadow_318-34042.png" alt="">--}}
                {{--</div>--}}
                {{--<div class="text-container">--}}
                    {{--<p>{{ json_decode(session('fb_user_data'))->name }}</p>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--@endif--}}
        </div>
        {{--<!-- Brand and toggle get grouped for better mobile display -->--}}
        <div class="navbar-header" style="background-color: #2B416D">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false"
                    style="background-color: lightgray!important;">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar" style="background-color: #222;"></span>
                <span class="icon-bar" style="background-color: #222;"></span>
                <span class="icon-bar" style="background-color: #222;"></span>
            </button>
            {{--<a class="navbar-brand" href="{{ url('/') }}"><img src="{{ asset('img/posthurry_logo.jpg') }}"></a>--}}
        </div>
        {{--<!-- Collect the nav links, forms, and other content for toggling -->--}}
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style="background-color: #2B416D">
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
            </ul>
        </div><!-- /.navbar-collapse -->
    </header>
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
@if(!isset($withoutHeader))
<div class="header2 footer">
	<div  class="col-md-3 item">
        <a href="{{ url('terms') }}">Terms of Service</a>
	</div>
    <div class="col-md-3 item">
        <a href="{{ url('privacy') }}">Privacy Policy</a>
	</div>
    <div  class="col-md-3 item">
        <a href="{{ url('faq') }}">FAQ</a>
	</div>
    <div  class="col-md-3 item">
        Copyright 2016 Post Hurry
	</div>
</div>
@endif
</body>
</html>