@extends('layouts.main')
@section('extra-messages')
    @if ($errors->has('email'))
        <div class="alert alert-danger messages">
            {{ $errors->first('email') }}
        </div>
    @endif
    @if ($errors->has('password'))
        <div class="alert alert-danger messages">
            {{ $errors->first('password') }}
        </div>
    @endif
    @if ($errors->has('password_confirmation'))
        <div class="alert alert-danger messages">
            {{ $errors->first('password_confirmation') }}
        </div>
    @endif
@endsection

@section('content')
<section class="signup pricer">
    <div class="container">
        <form class="registration" method="post"
              role="form" method="POST" action="{{ url('/password/reset') }}">
            <h2>Forget password</h2>
            <br>
            <div class="field{{ $errors->has('email') ? ' has-error' : '' }}">
                <input id="email" type="email" name="email"
                       value="{{ $email or old('email') }}"
                       placeholder="Email">
            </div>

            <div class="field{{ $errors->has('password') ? ' has-error' : '' }}">
                <input id="password" type="password" name="password"
                    placeholder="Password">
            </div>

            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <input id="password-confirm" type="password" name="password_confirmation"
                        placeholder="Confirm Password">
            </div>
            <input type="submit" value="Reset Password">
            <input type="hidden" name="token" value="{{ $token }}">
            {{ csrf_field() }}
        </form>
    </div>
</section>
@endsection