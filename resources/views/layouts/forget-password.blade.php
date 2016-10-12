@extends('layouts.main')
@section('content')
<section class="signup pricer">
    <div class="container">
        <form class="registration" method="post"
              role="form" method="POST" action="{{ url('/password/email') }}">
           {{ csrf_field() }}

            <h2>Forget password</h2>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="field {{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" placeholder="your email" name="email" required
                       value="{{ old('email') }}" />
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <input type="submit">
        </form>
    </div>
</section>
@endsection
