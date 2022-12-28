@extends('layouts.app')

@section('content')
<div class="container-sm">
    <div class="row row-cols-1 row-cols-lg-2 mt-5">
        <div class="col p-5">
            <h2>Reset Your Password</h2>
            <p>We have received your request to reset your account password.</p>
            <p>The allowed duration of the code is one hour from the time the message was sent</p>
        </div>
        <div class="col d-flex justify-content-center align-self-center text-center">
            <div class="p-5 m-5">
                <img src="/images/logo_big.png" class="img-fluid mb-3" width="400" height="300" alt="...">
                <h3>Welcome to Eventeur!</h3>
                <p class="fs-4 text-black-50"><small>The newest platform where you can find all the events you're looking for.</small></p>
                <p>Don't have an account already?<a class="ms-2" href="{{ url('/register') }}">Sign up</a></p>

            </div>
        </div>
    </div>
</div>
@endsection