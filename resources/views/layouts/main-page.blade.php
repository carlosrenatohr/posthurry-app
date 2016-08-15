@extends('layouts.main')
@section('others-css')
    <style>
        .teoprise a:last-child {
            pointer-events: auto;
        }

        .yearly-payment-form, .monthly-payment-form {
            display: none;
        }
    </style>
@endsection
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
                    <a href="{{ url('plans/yearly') }}">$189 peryear</a>
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

    @include('payment.monthly')
    @include('payment.yearly')
@endsection
