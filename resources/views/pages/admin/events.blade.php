@extends('layouts.app')

@section('title', '- Admin Events')

@section('content')

<div class="container-md">
    <h1 class="text-center ms-5">Admin - Events <a href="{{ url('/admin/createEvent') }}" class="ms-5 btn btn-primary">Create Event</a></h1>

    <div class="m-2">
        <form class="d-none d-sm-flex w-20 align-self-center form-inline w-100">
            <input type="text" class="form-control" id="searchevents" name="query" placeholder="Search Events" aria-label="Search" aria-describedby="button-addon2" value="">
            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                </svg>
            </button>
        </form>
    </div>

    <section id="cards" class="container row row-cols-2 justify-content-center">
        @each('pages.admin.partials.event', $events, 'event')
    </section>
</div>

@endsection