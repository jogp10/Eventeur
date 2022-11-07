@extends('layouts.app')

@section('title', $event->name)

@section('content')
  @include('partials.event', ['event' => $event])
@endsection
