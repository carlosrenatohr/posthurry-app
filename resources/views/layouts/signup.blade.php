@extends('layouts.main')
@section('content')
<section class="signup pricer">
    <div class="container">
        {!! Form::open(['url' => 'signup', 'method' => 'post', 'class' => 'registration'])!!}
            {{ csrf_field() }}
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
            <div class="field">
               <select class='form-control' name="timezones" placeholder="your timezones">
                    <option value="">select your timezone</option>
                    <option value="-12">(GMT -12:00) Eniwetok, Kwajalein</option>
                    <option value="-11">(GMT -11:00) Midway Island, Samoa</option>
                    <option value="-10">(GMT -10:00) Hawaii</option>
                    <option value="-9">(GMT -9:00) Alaska</option>
                    <option value="-3">(GMT -3:00) Pacific Time (US &amp; Canada)</option>
                    <option value="-4">(GMT -4:00) Mountain Time (US &amp; Canada)</option>
                    <option value="-5">(GMT -5:00) Central Time (US &amp; Canada), Mexico City</option>
                    <option value="-6">(GMT -6:00) Eastern Time (US &amp; Canada), Bogota, Lima</option>
                    <option value="-4.5">(GMT -4:30) Caracas</option>
                    <option value="-4">(GMT -4:00) Atlantic Time (Canada), La Paz, Santiago</option>
                    <option value="-3.5">(GMT -3:30) Newfoundland</option>
                    <option value="-3">(GMT -3:00) Brazil, Buenos Aires, Georgetown</option>
                    <option value="-2">(GMT -2:00) Mid-Atlantic</option>
                    <option value="-1">(GMT -1:00 hour) Azores, Cape Verde Islands</option>
                    <option value="0">(GMT) Western Europe Time, London, Lisbon, Casablanca, Greenwich</option>
                    <option value="1">(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris</option>
                    <option value="2">(GMT +2:00) Kaliningrad, South Africa, Cairo</option>
                    <option value="3">(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg</option>
                    <option value="3.5">(GMT +3:30) Tehran</option>
                    <option value="4">(GMT +4:00) Abu Dhabi, Muscat, Yerevan, Baku, Tbilisi</option>
                    <option value="4.5">(GMT +4:30) Kabul</option>
                    <option value="5">(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
                    <option value="5.5">(GMT +5:30) Mumbai, Kolkata, Chennai, New Delhi</option>
                    <option value="5.75">(GMT +5:45) Kathmandu</option>
                    <option value="6">(GMT +6:00) Almaty, Dhaka, Colombo</option>
                    <option value="6.5">(GMT +6:30) Yangon, Cocos Islands</option>
                    <option value="7">(GMT +7:00) Bangkok, Hanoi, Jakarta</option>
                    <option value="8">(GMT +8:00) Beijing, Perth, Singapore, Hong Kong</option>
                    <option value="9">(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk</option>
                    <option value="9.5">(GMT +9:30) Adelaide, Darwin</option>
                    <option value="10">(GMT +10:00) Eastern Australia, Guam, Vladivostok</option>
                    <option value="11">(GMT +11:00) Magadan, Solomon Islands, New Caledonia</option>
                    <option value="12">(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka</option>
                </select>
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
