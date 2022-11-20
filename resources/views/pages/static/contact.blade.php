@extends('layouts.app')

@section('title', 'About Us')
@section('content')
<div class="container-md ">
    <div class="row align-items-center">
        <div class="col">
            <h1>Contact Us</h1>
            <form method="POST" action=" {{ route('submitContact') }} ">
                @csrf
                <label for="name">Name</label><br>
                <input type="text" id="name" name="name"><br>
                <label for="email">Email</label><br>
                <input type="text" id="email" name="email"><br>
                <label for="subject">Subject</label><br>
                <input type="text" id="subject" name="subject"><br><br>
                <textarea id="content" name="content" rows="10" cols="45"></textarea><br><br>
                <input type="submit" value="Send Request">
            </form>
        </div>
        <div class="col">
            <img src="images/logo_big.png" class="img-fluid" height="600" width="800" alt="...">
        </div>
    </div>
</div>
@endsection
