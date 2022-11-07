@extends('layouts.app')

@section('content')
<section id="events">
    <div class="container">
      @each('partials.event', $events, 'event')
    </div>
<section>
@endsection

 