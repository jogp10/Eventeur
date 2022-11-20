@extends('layouts.app')

@section('content')
<div class="container-sm">
    <h3 class="my-5">Settings</h3>
    <h5 class="ps-5 mt-5">Profile Settings</h5>
    <form class="ps-5" method="POST" action="{{ route('admin.storeAccount') }}">
        @csrf
        <div class="row row-cols-2 border border-3 gx-0 py-4 px-3">
            <div class="col-12 col-lg-2">
                <label for="name" class="form-label"><span class="align-middle">Name</span></label>
            </div>
            <div class="col-12 col-lg-10">
                <input type="name" name="name" id="inputName" class="form-control" aria-describedby="nameHelpBlock" value="">
                <span id="nameHelpBlock" class="form-text pe-2">Set name</span>
            </div>
        </div>
        <div class="row row-cols-2 border border-3 gx-0 py-4 px-3">
            <div class="col-12 col-lg-2">
                <label for="name" class="form-label"><span class="align-middle">Email</span></label>
            </div>
            <div class="col-12 col-lg-10">
                <input type="name" name="email" id="inputEmail" class="form-control" aria-describedby="nameHelpBlock" value="">
                <span id="nameHelpBlock" class="form-text pe-2">Set email</span>
            </div>
        </div>
        <div class="row row-cols-2 border border-3 gx-0 py-4 px-3">
            <div class="col-12 col-lg-2">
                <label for="name" class="form-label"><span class="align-middle">Password</span></label>
            </div>
            <div class="col-12 col-lg-10">
                <input type="password" name="password" id="inputPassword" class="form-control" aria-describedby="nameHelpBlock" value="">
                <span id="nameHelpBlock" class="form-text pe-2">Set password</span>
            </div>
        </div>
        <div class="row row-cols-3 border border-3 gx-0 py-4 px-3">
            <div class="col-12 col-lg-4">
                <label for="inputUsername5" class="form-label"><span class="align-middle">Admin</span></label>
                <input id="inputAdmin" type="checkbox" name="admin" aria-describedby="nameHelpBlock" value="">
            </div>
            <div class="col-12 col-lg-12 form-floating clearfix">
                <button type="submit" class="btn btn-primary btn-lg float-end">Create Account</button>
            </div>
        </div>
    </form>
</div>
@endsection