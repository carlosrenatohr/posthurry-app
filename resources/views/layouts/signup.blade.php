@extends('layouts.main')
@section('content')
<section class="signup pricer">
    <div class="container">
        <form action="" class="registration">
            <h2>Registration Screen</h2>
            <div class="field">
                <input type="text" placeholder="your email" value="{{ session('useremail') }}">
            </div>
            <div class="field">
                <input type="text" placeholder="your password">
            </div>
            <div class="field">
                <input type="text" placeholder="verify your password">
            </div>
            {{--<div class="field">--}}
                {{--<button><img src="img/screen-fb.png" alt="">Authorize with facebook</button>--}}
            {{--</div>--}}
            <div class="checkbox">
                <label>
                    <input type="checkbox">
                    I am 14 or over to signup and I agree with the PostHurry <a href="/privacy" target="_blank">Privacy Policy</a> and
                    <a href="/terms" target="_blank">Terms of Service</a>, including the use of cookies.
                </label>
            </div>
            <input type="submit">
        </form>
    </div>
</section>
@endsection