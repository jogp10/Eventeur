@extends('layouts.app')

@section('title', 'About Us')
@section('content')
<div class="container-md ">
    <div class="row align-items-center">
        <div class="col">
            <h1 style="padding:6rem 0rem 3rem 0rem">Contact Us</h1>
            <form action="/">
                <label for="name">Name</label><br>
                <input type="text" id="name" name="name" style="width:80%"><br>
                <label for="email">Email</label><br>
                <input type="email" id="email" name="email" style="width:80%"><br>
                <label for="subject">Subject</label><br>
                <input type="text" id="subject" name="subject" style="width:80%"><br><br>
                <textarea id="content" name="content" rows="10" cols="45"></textarea><br><br>
                <input type="submit" value="Send Request" style="right:0">
            </form>
        </div>
        <div class="col" style="text-align:center;">
            <img src="images/logo_big.png" class="img-fluid" height="600" width="800" alt="...">
        </div>
    </div>
</div>
@endsection