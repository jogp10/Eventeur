@extends('layouts.app')


@section('content')
<div class="container-md">
    <h1 class="text-center m-3 mt-4">Event Settings</h1>
    <div class="row">
        <div class="col">
            <nav class="border-bottom border-3" style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                <ol class="breadcrumb ps-5 mb-2">
                    <li class="breadcrumb-item me-2" aria-current="page"><a class="link-dark text-decoration-none" href="{{ route('eventSettings', ['id' => $event->id]) }}">
                            <p class="m-0 fs-5">Settings</p>
                        </a></li>
                    <li class="breadcrumb-item active"><a class="link-secondary text-decoration-none" href="{{ route('eventParticipants', ['id' => $event->id]) }}">
                            <p class="m-0 fs-5">Participants</p>
                        </a></li>
                </ol>
            </nav>
        </div>
    </div>


    <div class="row mt-5 ps-2">
        <div class="container">
            <form method="POST" action="{{ route( 'editEvent', $event->id) }}">
                @csrf
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" id="exampleFormControlInput1" value="{{$event->name}}">
                </div>

                @foreach($event->tags as $tag)
                <div class="form-check">
                    <input class="form-check-input" name="tags[]" type="checkbox" value="" id="flexCheckDefault" checked>
                    <label class="form-check-label" for="flexCheckDefault">{{$tag->name}}</label>
                </div>
                @endforeach

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

                <div class="mt-4 form-check form-switch">
                    <label class="form-check-label" for="flexSwitchCheckDefault">Privacy</label>
                    <input class="form-check-input" name="privacy" type="checkbox" role="switch" id="flexSwitchCheckDefault" @if($event->privacy=='Private')checked @endif>
                </div>

                <div class="mb-4 mt-4">
                    <label for="exampleFormControlTextarea1" name="description" class="form-label">Description</label>
                    <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="13">{{$event->description}}</textarea>
                </div>
                <div class="clearfix mb-3">
                    <button type="submit" class="btn btn-primary btn-lg float-end">Save Settings</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection