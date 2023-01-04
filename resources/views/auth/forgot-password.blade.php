@extends('layouts.app')

@section('content')
<div class="container-sm">
    <div class="row row-cols-1 row-cols-lg-2 mt-5">
        <div class="col p-5">
            <h2>Reset Your Password</h2>
            <p>Enter your email address and we'll send you a link to reset your password.</p>
            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    @if ($errors->has('email'))
                    <span class="error">
                        {{ $errors->first('email') }}
                    </span>
                    @endif
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
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