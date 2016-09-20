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

@endsection

@section('content')
    <div class="container pricer">
        <div class="row">
            <div class="boxprice">
                <p>PostHurry is an innovative way to get your message out there. Using your personal Facebook profile,
                    PostHurry gives you the ability to schedule and post content on multiple groups and pages at once;
                    we call them “blasts” because that’s exactly what they do! With PostHurry, the possibilities are
                    endless - use them to promote yourself, your business or host a contest. It's easy!</p>
                <h4>One Size Fits All plan</h4>
                <a href="{{ url('signup?package=trial') }}">Free 7 Day Trial</a>


                <ul>
                    <li>Easy and intuitive!</li>
                    <li>Contest promotion</li>
                    <li>Share to multiple Groups and Pages at once!</li>
                    <li>Analytics included</li>
                    <li>Post to hundreds of Groups daily!</li>
                </ul>
                <div class="teoprise">
                    <a href="{{ url('?signup?package=monthly') }}">$19 per month</a>
                    <a href="{{ url('signup?package=yearly') }}">$189 per year</a>
                </div>
                <div class="ofer"><a href="#">Limited Time Offer Here!!!</a></div>
                <p>It’s easy! PostHurry’s interface is easy and effective. In your PostHurry account, you can view
                    current and previous blasts. Don’t want to go through the hassle of seeing how your post is doing on
                    multiple pages? No problem. PostHurry includes analytical tools that will show you exactly how your
                    content is doing. Ready to start blasting? Try PostHurry today!</p>
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
