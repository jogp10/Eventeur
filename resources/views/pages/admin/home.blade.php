@extends('layouts.app')

@section('title', 'Admin')

@section('content')

<div class="container-md">
    <h1>Admin</h1>

    <a href="{{ url('/admin/users') }}">Users</a>



</div>

@endsection