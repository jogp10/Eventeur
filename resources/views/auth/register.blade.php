@extends('layouts.app')

@section('content')
<div class="container-sm">
    <div class="row row-cols-1 row-cols-lg-2 mt-5">
       <div class="col p-5">
           <h2>Sign Up</h2>
           <p>By continuing you agree to our user Agreement and Privacy Policy.</p>
           <form method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="name" class="form-control" id="name" name="name" required>
                    @if ($errors->has('name'))
                        <span class="error">
                            {{ $errors->first('name') }}
                        </span>
                    @endif
               </div>
               <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    @if ($errors->has('email'))
                        <span class="error">
                            {{ $errors->first('email') }}
                        </span>
                    @endif
               </div>
               <div class="mb-3">
                   <label for="password" class="form-label">Password</label>
                   <input type="password" class="form-control" id="password" name="password" required>
                   @if ($errors->has('password'))
                        <span class="error">
                            {{ $errors->first('password') }}
                        </span>
                    @endif
               </div>
               <div class="mb-3">
                    <label for="Password-confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password-confirm" name="password_confirmation" required>
                    @if ($errors->has('password_confirmation'))
                        <span class="error">
                            {{ $errors->first('password_confirmation') }}
                        </span>
                    @endif
               </div>
               <div class="mb-3">
                     <a href="{{ route('password.request') }}">Forgot your password?</a>
                </div>
               <div class="mb-3">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label">Remember Me</label>
                    </div>
               </div>
               <button type="submit" class="btn btn-primary">Submit</button>
           </form>
       </div>
       <div class="col d-flex justify-content-center align-self-center text-center">
           <div class="p-5 m-5">
               <img src="/images/logo_big.png" class="img-fluid mb-3" width="400" height="300" alt="...">
               <h3>Welcome to Eventeur!</h3>
               <p class="fs-4 text-black-50"><small>The newest platform where you can find all the events you're looking for.</small></p>
               <p>Have an account already?<a class="ms-2" href="{{ url('/login') }}">log In</a></p>
               
           </div>
       </div>
    </div>
</div>
@endsection