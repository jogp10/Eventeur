@extends('layouts.app')

@section('content')
<div class="container-md">
  @each('partials.event', $events, 'event')
</div>
@endsection