@extends('layouts.main')
@section('content')
<section class="signup pricer">
    <div class="container">
        <form action="" class="registration" method="post">
           {{ csrf_field() }}
             <h2>Forget password</h2>
            <div class="field">
                <input type="email" placeholder="your email" name="email" required>
            </div>
            <input type="submit">
        </form>
    </div>
</section>
@endsection
