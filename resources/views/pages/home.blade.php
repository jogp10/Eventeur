@extends('layouts.app')

@section('content')
@if(!Auth::check())
<div class="container-md">
  @each('partials.event', $events, 'event')
</div>
@else
<div class="container-lg">
  <div class="row row-cols-1 row-cols-lg-2">
    <div class="col col-lg-10">
      @each('partials.event', $events, 'event')
    </div>
    <div class="col col-lg-2 border border-grey align-self-start mt-5">
      <div class="d-flex flex-column p-3">
        <h2>Create an Event</h2>
        <p>Are you going to host an event? Create and share here!</p>
        <a class="btn btn-secondary btn-lg" href="{{route('createEvent')}}">
          <span>Create Event</span>
        </a>
      </div>
    </div>
  </div>
</div>
@endif
@endsection