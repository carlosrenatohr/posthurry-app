@extends('layouts.main')
@section('content')
<section class="signup pricer">
    <div class="container">
        <form action="" class="registration" method="post">
           {{ csrf_field() }}
             <h2>Login</h2>
            <div class="field">
                <input type="text" placeholder="your email" name="email">
            </div>
            <div class="field">
                <input type="password" placeholder="your password" name="password">
            </div>
            <div class="field">
                <a href="{{ url('reset') }}" style="color: #FFF;font-size: 16px;">Forgot password?</a>
            </div>
            <input type="submit">
        </form>
    </div>
</section>
@endsection
