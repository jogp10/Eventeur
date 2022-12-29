@extends('layouts.app')

@section('content')
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
    <div class="row mt-5 ps-5">
        <div class="col">
            <h5>Profile Image</h5>
            <div class="d-flex flex-column flex-sm-row border border-3">
                <div class="align-self-center mb-4">
                    <img src="/images/profiles/{{$account->user->profileImage->name}}" class="rounded-circle img-fluid rounded-circle me-4" height="100" width="90" alt="...">
                </div>
                <div class="align-self-center">
                    <form class="ps-5" method="POST" action="{{ route('editProfileImage', ['id' => $account->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <strong>{{ $message }}</strong>
                        </div>
                        @endif
                        @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <input type="file" name="image" class="btn btn-primary" accept="image/*" value="Update Profile Image">
                        <button type="submit" name="submit" class="btn btn-primary btn-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                            </svg>
                        </button>
                        <p class="mb-0"><small>Must be JPEG, PNG or GIF and cannot exceed 10MG</small></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4 mb-0 ps-5">
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
    @include('partials.profileSettings')
    @include('partials.securitySection')
</div>


@endsection