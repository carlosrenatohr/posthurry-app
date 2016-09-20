@extends('layouts.main')
@section('content')
<section class="signup pricer">
    <div class="container">
        {!! Form::open(['url' => 'signup', 'method' => 'post', 'class' => 'registration'])!!}
            <h2>Registration Screen</h2>
            <div class="field">
                <input type="text" name="name" placeholder="your name">
            </div>
            <div class="field">
                <input type="email" name="email" placeholder="your email" name="email">
            </div>
            <div class="field">
                <input type="password" placeholder="your password" name="password">
            </div>
             {{--<div class="field">--}}
                {{--<button><img src="img/screen-fb.png" alt="">Authorize with facebook</button>--}}
            {{--</div>--}}
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="acceptTerms" required>
                   I am 14 or over to signup and I agree with the PostHurry <a href="/privacy" target="_blank">Privacy Policy</a> and
                    <a href="/terms" target="_blank">Terms of Service</a>, including the use of cookies.
                </label>
            </div>
            <input type='hidden' name='package' value='{{ $package }}'>
            <input type="submit">
        {!! Form::open(['url' => 'signup', 'method' => 'post'])!!}
    </div>
</section>
@endsection
