@extends('layouts.app')

@section('content')
<section id="events">
    <div class="container-md">
      @each('partials.event', $events, 'event')
    </div>
<section>
@endsection

 