@extends('layouts.main')
@section('content')
    <section class="heading">
        <div class="container">
            <div class="row">
                <div class="col-sm-9 col-xs-8">
                    <h3>Settings</h3>
                </div>
            </div>
        </div>
    </section>

    <section class='content'>
        <div class='container'>
            <div class='row'>
                <div class='col-md-9'>
                    <form method='post'>
                        {{ csrf_field() }}
                        <div class='row'>
                            <div class='col-md-4'>
                                Select your timezone 
                            </div>
                            <div class='col-md-8'>
                               <select class='form-control' name="timezones">
                                    <option @if(@$user->timezones == '-12') selected="selected" @endif value="-12">(GMT -12:00) Eniwetok, Kwajalein</option>
                                    <option @if(@$user->timezones == '-11') selected="selected" @endif value="-11">(GMT -11:00) Midway Island, Samoa</option>
                                    <option @if(@$user->timezones == '-10') selected="selected" @endif value="-10">(GMT -10:00) Hawaii</option>
                                    <option @if(@$user->timezones == '-9') selected="selected" @endif value="-9">(GMT -9:00) Alaska</option>
                                    <option @if(@$user->timezones == '-3') selected="selected" @endif value="-3">(GMT -3:00) Pacific Time (US &amp; Canada)</option>
                                    <option @if(@$user->timezones == '-4') selected="selected" @endif value="-4">(GMT -4:00) Mountain Time (US &amp; Canada)</option>
                                    <option @if(@$user->timezones == '-5') selected="selected" @endif value="-5">(GMT -5:00) Central Time (US &amp; Canada), Mexico City</option>
                                    <option @if(@$user->timezones == '-6') selected="selected" @endif value="-6">(GMT -6:00) Eastern Time (US &amp; Canada), Bogota, Lima</option>
                                    <option @if(@$user->timezones == '-4.5') selected="selected" @endif value="-4.5">(GMT -4:30) Caracas</option>
                                    <option @if(@$user->timezones == '-4') selected="selected" @endif value="-4">(GMT -4:00) Atlantic Time (Canada), La Paz, Santiago</option>
                                    <option @if(@$user->timezones == '-3.5') selected="selected" @endif value="-3.5">(GMT -3:30) Newfoundland</option>
                                    <option @if(@$user->timezones == '-3') selected="selected" @endif value="-3">(GMT -3:00) Brazil, Buenos Aires, Georgetown</option>
                                    <option @if(@$user->timezones == '-2') selected="selected" @endif value="-2">(GMT -2:00) Mid-Atlantic</option>
                                    <option @if(@$user->timezones == '-1') selected="selected" @endif value="-1">(GMT -1:00 hour) Azores, Cape Verde Islands</option>
                                    <option @if(@$user->timezones == '0' || empty($user->timezones)) selected="selected" @endif value="0">(GMT) Western Europe Time, London, Lisbon, Casablanca, Greenwich</option>
                                    <option @if(@$user->timezones == '1') selected="selected" @endif value="1">(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris</option>
                                    <option @if(@$user->timezones == '2') selected="selected" @endif value="2">(GMT +2:00) Kaliningrad, South Africa, Cairo</option>
                                    <option @if(@$user->timezones == '3') selected="selected" @endif value="3">(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg</option>
                                    <option @if(@$user->timezones == '3.5') selected="selected" @endif value="3.5">(GMT +3:30) Tehran</option>
                                    <option @if(@$user->timezones == '4') selected="selected" @endif value="4">(GMT +4:00) Abu Dhabi, Muscat, Yerevan, Baku, Tbilisi</option>
                                    <option @if(@$user->timezones == '4.5') selected="selected" @endif value="4.5">(GMT +4:30) Kabul</option>
                                    <option @if(@$user->timezones == '5') selected="selected" @endif value="5">(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
                                    <option @if(@$user->timezones == '5.5') selected="selected" @endif value="5.5">(GMT +5:30) Mumbai, Kolkata, Chennai, New Delhi</option>
                                    <option @if(@$user->timezones == '5.75') selected="selected" @endif value="5.75">(GMT +5:45) Kathmandu</option>
                                    <option @if(@$user->timezones == '6') selected="selected" @endif value="6">(GMT +6:00) Almaty, Dhaka, Colombo</option>
                                    <option @if(@$user->timezones == '6.5') selected="selected" @endif value="6.5">(GMT +6:30) Yangon, Cocos Islands</option>
                                    <option @if(@$user->timezones == '7') selected="selected" @endif value="7">(GMT +7:00) Bangkok, Hanoi, Jakarta</option>
                                    <option @if(@$user->timezones == '8') selected="selected" @endif value="8">(GMT +8:00) Beijing, Perth, Singapore, Hong Kong</option>
                                    <option @if(@$user->timezones == '9') selected="selected" @endif value="9">(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk</option>
                                    <option @if(@$user->timezones == '9.5') selected="selected" @endif value="9.5">(GMT +9:30) Adelaide, Darwin</option>
                                    <option @if(@$user->timezones == '10') selected="selected" @endif value="10">(GMT +10:00) Eastern Australia, Guam, Vladivostok</option>
                                    <option @if(@$user->timezones == '11') selected="selected" @endif value="11">(GMT +11:00) Magadan, Solomon Islands, New Caledonia</option>
                                    <option @if(@$user->timezones == '12') selected="selected" @endif value="12">(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka</option>
                                </select>
                            </div>
                        </div> 
    
                        <input type='submit' name='submit' value='save' class='btn btn-primary'>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
