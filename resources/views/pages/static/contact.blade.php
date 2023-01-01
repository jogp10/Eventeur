@extends('layouts.app')

@section('title', 'About Us')
@section('content')
<div class="container-md pt-4 d-flex flex-column">
    <h1 class="my-5 px-5 text-center">Contact Us</h1>
    <div class="row row-cols-1 row-cols-md-2 flex-column-reverse flex-md-row gx-5">
        <div class="col">
            <form method="POST" action=" {{ route('submitContact') }} ">
                @csrf
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" name="name" class="form-control mb-3">

                <label for="email" class="form-label">Email</label>
                <input type="text" id="email" name="email" class="form-control mb-3">

                <label for="subject" class="form-label">Subject</label><br>
                <input type="text" id="subject" name="subject" class="form-control mb-3">

                <textarea id="content_form" name="content_form" rows="10" cols="45" class="form-control"></textarea>
                <button type="submit" class="form-control my-4">Send Request</button>
            </form>
        </div>
        <div class="col align-self-center mt-5">
            <img src="images/logo_big.png" class="img-fluid" height="500" width="600" alt="...">
        </div>
    </div>
</div>
@endsection