<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<header>
    <nav class="navbar navbar-default main-navbar">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ asset('img/posthurry_logo.jpg') }}"></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    {{--<li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>--}}
                    <li><a href="{{ url('comparison') }}">List of comparisons </a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</header>
<div class="main-container">
    <div class="container-fluid">
        <img src="{{ asset('img/loading.gif') }}" alt="" class="img-responsive img-loading hide" style="max-width: 150px;position: absolute;right: 0;">
        @yield('content')
    </div>
    {{ Form::hidden('fb_scopes', implode(',', config('laravel-facebook-sdk.default_scope')), ['id' => 'fb_scopes']) }}
</div>
<script src="{{ asset('js/all.js') }}"></script>
@yield('others-js')
</body>
{{--<div id="loading-image" style="position: fixed;width: 100%; height: 100%; top:0;left: 0; background-color: #222;z-index: 999;"></div>--}}
</html>