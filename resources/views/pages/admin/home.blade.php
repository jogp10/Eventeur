@extends('layouts.app')

@section('title', 'Admin')

@section('content')

<div class="container-md">
    <h1>Admin</h1>
    <p><a href="{{ url('/admin/users') }}">Users</a></p>
    <p><a href="{{ url('/admin/events') }}">Events</a></p>
</div>

@endsection