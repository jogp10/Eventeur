@extends('layouts.app')

@section('title', '- Edit User')

@section('content')
<div class="container-sm">
    <h3 class="my-5">Settings</h3>
    <div class="row">
        <div class="col">
            <nav class="border-bottom border-3" style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                <ol class="breadcrumb ps-5 mb-2">
                    <li class="breadcrumb-item me-2" aria-current="page"><a
                            class="link-dark text-decoration-none" href="{{ url('/editProfile') }}">
                            <p class="m-0 fs-5">Settings</p>
                        </a></li>
                    <li class="breadcrumb-item active"><a class="link-secondary text-decoration-none" href="{{ url('/settigsProfile') }}">
                            <p class="m-0 fs-5">Security</p>
                        </a></li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row mt-5 ps-5">
        <div class="col">
            <h5>Profile Image</h5>
            <div class="d-flex flex-column flex-sm-row border border-3">
                <div class="align-self-center mb-4">
                    <img src="/images/profiles/{{$account->user->profileImage->name}}" class="img-fluid rounded-circle me-4" height="100" width="90"
                        alt="...">
                </div>
                <div class="align-self-center">
                    <button class="btn btn-primary btn-lg">Update Profile Image</button>
                    <button class="btn btn-primary btn-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-trash3" viewBox="0 0 16 16">
                            <path
                                d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                        </svg>
                    </button>
                    <p class="mb-0"><small>Must be JPEG, PNG or GIF and cannot exceed 10MG</small></p>
                </div>
            </div>
        </div>
    </div>
    <h5 class="ps-5 mt-5">Profile Settings</h5>
    <form class="ps-5" method="POST" action="{{ route('admin.updateUser', ['id' => $account->id]) }}">
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
                    <textarea class="form-control" name="description" id="floatingTextarea2" style="height: 300px"> {{$account->description}} </textarea>
                    <div id="nameHelpBlock" class="form-text pe-2">Must not exceed 200 characters</div>
                    <div class="clearfix">
                        <button type="submit" class="btn btn-primary btn-lg float-end">Save Settings</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection