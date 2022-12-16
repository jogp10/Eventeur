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
        <li class="breadcrumb-item" aria-current="page" ><a href="#" style="text-decoration: none; color: black;">Settings</a></li>
      </ol>
    </nav>
    @endif

    <h3 class="my-3">Settings</h3>

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
    <section id="settings" class="mb-5">
        <form class="ps-5" method="POST" action="{{ route('editProfile', ['id' => $account->id]) }}">
            @method('PUT')
            @csrf
            <div class="row row-cols-2 border border-3 gx-0 py-4 px-3">
                <div class="col-12 col-lg-2">
                    <label for="name" class="form-label"><span class="align-middle">Name</span></label>
                </div>
                <div class="col-12 col-lg-10">
                    <input type="name" name="name" id="inputName" class="form-control" aria-describedby="nameHelpBlock" value="{{$account->name}}">
                    <div id="nameHelpBlock" class="form-text pe-2">Change your password</div>
                </div>
            </div>
            <div class="row row-cols-3 border border-3 gx-0 py-4 px-3">
                <div class="col-12 col-lg-2">
                    <label for="inputUsername5" class="form-label"><span class="align-middle">Description</span></label>
                </div>
                <div class="col-12 col-lg-10">
                    <div class="form-floating">
                        <textarea class="form-control" name="description" id="floatingTextarea2" style="height: 300px">{{$account->description}}</textarea>
                        <div id="nameHelpBlock" class="form-text pe-2">Must not exceed 200 characters</div>
                        <div class="clearfix">
                            <button type="submit" class="btn btn-primary btn-lg float-end">Save Settings</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
     
    <section id="security" class="visually-hidden mb-5">
        <form class="ps-5" method="POST" action="{{ route('editProfilePassword', ['id' => $account->id]) }}">
            @method('PUT')
            @csrf
            <div class="row row-cols-2 border border-3 gx-0 py-4 px-3">
                <div class="col-12 col-lg-2">
                    <label for="password" class="form-label"><span class="align-middle">Old Password</span></label>
                </div>
                <div class="col-12 col-lg-10 pb-3">
                    <input type="password" name="oldPassword" id="inputName" class="form-control" aria-describedby="nameHelpBlock">
                    @if ($errors->has('oldPassword'))
                    <span class="error">
                        {{ $errors->first('oldPassword') }}
                    </span>
                    @endif
                </div>
                <div class="col-12 col-lg-2">
                    <label for="password" class="form-label"><span class="align-middle">New Password</span></label>
                </div>
                <div class="col-12 col-lg-10 pb-3">
                    <input type="password" name="newPassword" id="inputName" class="form-control" aria-describedby="nameHelpBlock">
                    @if ($errors->has('newPassword'))
                    <span class="error">
                        {{ $errors->first('newPassword') }}
                    </span>
                    @endif
                </div>
                <div class="col-12 col-lg-2">
                    <label for="password" class="form-label"><span class="align-middle">Confirm Password</span></label>
                </div>
                <div class="col-12 col-lg-10">
                    <input type="password" name="password_confirmation" id="inputName" class="form-control" aria-describedby="nameHelpBlock">
                    @if ($errors->has('password_confirmation'))
                    <span class="error">
                        {{ $errors->first('password_confirmation') }}
                    </span>
                    @endif
                </div>
                <div class="col-12 mt-2 ">
                    <div class="form-floating">
                        <div class="clearfix">
                            <button type="submit" class="btn btn-primary liveAlertBtn btn-lg float-end">Save Settings</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <form class="ps-5" method="POST" action="{{ route('editProfileEmail', ['id' => $account->id]) }}">
            @method('PUT')
            @csrf
            <div class="row row-cols-2 border border-3 gx-0 py-4 px-3">
                <div class="col-12 col-lg-3">
                    <label for="email" class="form-label"><span class="align-middle">New Email Address</span></label>
                </div>
                <div class="col-12 col-lg-9 pb-3">
                    <input type="email" name="newEmail" id="inputName" class="form-control" aria-describedby="nameHelpBlock">
                    @if ($errors->has('newEmail'))
                    <span class="error">
                        {{ $errors->first('newEmail') }}
                    </span>
                    @endif
                </div>
                <div class="col-12 col-lg-3">
                    <label for="email" class="form-label"><span class="align-middle">Confirm Email Address</span></label>
                </div>
                <div class="col-12 col-lg-9">
                    <input type="email" name="confirmedEmail" id="inputName" class="form-control" aria-describedby="nameHelpBlock">
                    @if ($errors->has('confirmedEmail'))
                    <span class="error">
                        {{ $errors->first('confirmedEmail') }}
                    </span>
                    @endif
                </div>
                <div class="col-12 mt-2">
                    <div class="form-floating">
                        <div class="clearfix">
                            <button type="submit" class="btn btn-primary btn-lg liveAlertBtn float-end">Save Settings</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
    <div class="Row mt-2 pt-3 pb-4">
        <div class="Col position-relative">
            <button id="open-popup" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-danger position-absolute bottom-0 end-0"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
            </svg>Delete Account</button>
        
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Are you sure you want to delete your account?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="{{ route('Delete', $account->id) }}" id="open-popup" type="button" class="btn btn-danger"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                    </svg>Delete Account</a>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>


@endsection