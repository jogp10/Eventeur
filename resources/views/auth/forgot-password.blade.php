@extends('layouts.app')

@section('content')
<div class="container-md">
    <div class="mb-3">
        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </form>
    </div>
</div>
@endsection