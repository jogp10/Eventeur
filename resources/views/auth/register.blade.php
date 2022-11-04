@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row row-cols-1 row-cols-md-2 mt-5">
       <div class="col border border-dark p-5">
           <h2>Sign Up</h2>
           <p>By continuing you agree to our user Agreement and Privacy Policy.</p>
           <form method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Username</label>
                    <input type="username" class="form-control" id="username" aria-describedby="usernameHelp" value="{{ old('name') }}">
                    @if ($errors->has('username'))
                        <span class="error">
                            {{ $errors->first('username') }}
                        </span>
                    @endif
               </div>
               <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" value="{{ old('email') }}">
                    @if ($errors->has('email'))
                        <span class="error">
                            {{ $errors->first('email') }}
                        </span>
                    @endif
               </div>
               <div class="mb-3">
                   <label for="exampleInputPassword1" class="form-label">Password</label>
                   <input type="password" class="form-control" id="password">
                   @if ($errors->has('password'))
                        <span class="error">
                            {{ $errors->first('password') }}
                        </span>
                    @endif
               </div>
               <div class="mb-3">
                    <label for="exampleInputPasswordConfirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password">
                    @if ($errors->has('password'))
                        <span class="error">
                            {{ $errors->first('password') }}
                        </span>
                    @endif
               </div>
               <div class="mb-3">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                    </label>  
               </div>
               <button type="submit" class="btn btn-primary">Submit</button>
           </form>
       </div>
       <div class="col d-flex justify-content-center align-self-center text-center">
           <div class="p-5 m-5">
               <img src="images/logo.png" class="img-fluid mb-3" width="400" height="300" alt="...">
               <h3>Welcome to Eventeur!</h3>
               <p class="fs-4 text-black-50"><small>The newest platform where you can find all the events you're looking for.</small></p>
               <p>Have an account already?<a class="ms-2" href="#">Sign in</a></p>
               
           </div>
       </div>
    </div>
</div>
@endsection