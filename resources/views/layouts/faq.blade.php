@extends('layouts.main')
@section('others-js')
    {{--<script src="{{ asset('js/access.js') }}"></script>--}}
@endsection
@section('pageTitle')
    | Privacy Policy
@endsection
<style>

</style>
@section('content')
    <div class="col-md-8 col-md-offset-2">
        <h1 class="h1-simplepage pull-left">FAQ</h1>
        <div class="simplepage-content" id="faq-content">
            <h2>POSTHURRY Frequently Asked Questions</h2>

            <h3>What are PostHurry's social media security practices?</h3>
            <ol>
                <li>1. When users access the website, they go through Secure Login. This means your credentials are encrypted through secure sockets layer (SSL), an encryption protocol that uses public-key crypto.</li>
                <li>2. PostHurry only interacts with Facebook through application programming interface (API) calls.</li>
                <li>3. We use open authorization (OAuth) when connecting to Facebook.
                    This also means we do not store usernames and passwords for social networks on servers.</li>
            </ol>

            <h3>I posted to Groups and Pages but they are not showing up?</h3>
            <ol>
                <li>1. Public Groups and Pages do not require prior approval.</li>
                <li>2. The Closed or Secret Groups and Pages may require Admin approval before they are shown. The time period to approve the post is up to the Group or Page Admin.</li>
                <li>3. If you are unsure if you may post to a certain Group or Page, contact the Group or Page Admin for approval.</li>
            </ol>

            <h3>Will my posts be classified as spam?</h3>
            <ol>
                <li>1.	To avoid your posts being categorized as spam, it is good to take it slow to add Groups and Pages and don’t add more than 1 posts to the same Group or Page in a day.</li>
            </ol>

            <h3>I would like to refer people to your website, is there a referral fee?</h3>
            <ol>
                <li>1. Yes, we will have a referral program soon. We will send you an email to your Facebook Account when it is added.</li>
            </ol>

            <h3>I would like to contact you, what is your email address?</h3>
            <ol>
                <li>1.	Our email address is <a href="mail:info@GetPostHurry.com">info@GetPostHurry.com</a>. Please allow up to 24 hours for a reply.</li>
            </ol>
        </div>
    </div>
@endsection