@extends('layouts.app')

@section('content')
@if( Session::has('message'))
    <div class="alert alert-success" role="alert">
      {{ Session::get('message')}}
    </div>
@endif
<div class="container-sm position-relative">

    @if (Auth::user() && $account->id === Auth::user()->id)
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mt-3 mb-2">
            <span></span>
            <li class="breadcrumb-item active"><a href="{{ url('/profile', Auth::id()) }}" style="text-decoration: none; color: grey;">Profile</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="#" style="text-decoration: none; color: black;">Settings</a></li>
        </ol>
    </nav>
    @endif
    <div class="row">
        <div class="col">
            <nav class="border-bottom border-3" style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                <ol class="breadcrumb ps-5">
                    <li class="breadcrumb-item me-2" aria-current="page"><button id="settings-button" type="button" class="btn btn-link text-decoration-none" style="color: black">
                    <span class="m-0 p-0 fs-5">Settings</span></button></li>
                    <li class="breadcrumb-item active"><button id="security-button" type="button" class="btn btn-link text-decoration-none" style="color: grey">
                            <span class="m-0 p-0 fs-5">Security</span>
                        </button></li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row mt-5 ps-5">
        <div class="col">
            <h5>Profile Image</h5>
            <div class="d-flex flex-column flex-sm-row border border-3">
                <div class="align-self-center mb-4">
                    <img src="/images/perfil.png" class="rounded-circle img-fluid rounded-circle me-4" height="100" width="90" alt="...">
                </div>
                <div class="align-self-center">
                    <button class="btn btn-primary btn-lg">Update Profile Image</button>
                    <button class="btn btn-primary btn-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                            <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                        </svg>
                    </button>
                    <p class="mb-0"><small>Must be JPEG, PNG or GIF and cannot exceed 10MG</small></p>
                </div>
            </div>
        </div>
    </div>
    <h5 class="ps-5 mt-5">Profile Settings</h5>
    @include('partials.profileSettings')
     
    @include('partials.securitySection')
</div>


@endsection