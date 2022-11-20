@extends('layouts.app')


@section('content')
<h1 class="text-center m-3 mt-4">Event Settings</h1>

<main>
    <div class="container">
        <form method="POST" action="{{ route( 'editEvent', $event->id) }}">
            @csrf
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" id="exampleFormControlInput1">
            </div>

           
            <div class="form-check">
                <input class="form-check-input" name="tags[]" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">Fitness</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="tags[]" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckChecked">Nature</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="tags[]" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckChecked">Sports</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" name="tags[]" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckChecked">Geography</label>
            </div>
    
            <div class="form-check form-switch">
                <input class="form-check-input" name="privacy" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                <label class="form-check-label" for="flexSwitchCheckDefault"></label>
            </div>

            <div class="mb-4 mt-4">
                <label for="exampleFormControlTextarea1" name="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="13"></textarea>
            </div>
            <div class="clearfix mb-3">
                <button type="submit" class="btn btn-primary btn-lg float-end">Save Settings</button>
            </div>
        </form>
    </div>
</main>
@endsection