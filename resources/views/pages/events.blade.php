@extends('layouts.app')

@section('title', '- Events')

@section('content')

<section id="cards">
  @each('partials.event', $events, 'event')
</section>

@endsection
