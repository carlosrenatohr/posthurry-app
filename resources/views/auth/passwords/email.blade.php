@extends('layouts.main')
@section('extra-messages')
    @if ($errors->has('email'))
        <div class="alert alert-danger messages">
            {{ $errors->first('email') }}
        </div>
    @endif
@endsection
@section('content')
    <section class="signup pricer">
        <div class="container">
            <form class="registration" method="post"
                  role="form" method="POST" action="{{ url('/password/email') }}">
                {{ csrf_field() }}

                <h2>Forget password</h2>
                <div class="field {{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" placeholder="your email" name="email" required
                           value="{{ old('email') }}" />
                </div>
                <input type="submit">
            </form>
        </div>
    </section>
@endsection
