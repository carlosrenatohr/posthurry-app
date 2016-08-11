@extends('layouts.main')
@section('others-js')
    <script>
        $(document).ready(function (e) {
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

            $('.fb-login-btn').on('click', function (e) {
                e.preventDefault();
                $.ajax({
                    url: '/gettingUrl',
                    method: 'post',
                    dataType: 'json',
                    success: function (data) {
                        window.location.href = data.url;
                    }
                });
            });

            $(".monthly-payment-button").on('click', function () {
                $(".monthly-payment-form").submit();
            })

            $(".yearly-payment-button").on('click', function () {
                $(".yearly-payment-form").submit();
            })
        });

    </script>
@endsection

@section('content')
    <style>
        .teoprise a:last-child {
            pointer-events: auto;
        }

        .yearly-payment-form, .monthly-payment-form {
            display: none;
        }
    </style>
    <div class="container-fluid newsty">
        <div class="container">
            <header>
                <div class="logosec">
                    <span><a href="#"><img src="{{ asset('img/logo-new.png') }}" alt="logo"/></a><br>When time is money, use PostHurry!</span>
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


    <div class="container pricer">
        <div class="row">
            <div class="boxprice">
                <h4>One Size Fits All plan</h4>
                <a href="#">Free 7 Day Trial</a>

                <ul>
                    <li>Post to multiple Facebook Groups and Pages with one Post.</li>
                    <li>Post to 100’s of Groups and Pages daily.</li>
                    <li>Measure results per Contest post.</li>
                    <li>Blast the winning post.</li>
                    <li>Schedule the blasts.</li>
                    <li>Unlimited Contests per month.</li>
                </ul>
                <div class="teoprise">
                    <a href="{{ url('plans/monthly') }}">$19 per month</a>
                    <a href="#{{ url('plans/yearly') }}">$189 peryear</a>
                </div>
                <div class="ofer"><a href="#">Limited Time Offer Here!!!</a></div>
                <div class="limitoff">
                    <div class="limit">
                        <div class="closed2">X</div>
                        <a href="#" disabled="">
                            <span>Limited Time only!!! </span>
                            <span>$149 per year!</span>
                            <span>First 100 sign ups only </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    @include('payment.monthly')
    @include('payment.yearly')
@endsection
