@extends('layouts.app')

@section('title', '- Profile')

@section('content')
<div class="container">

    @if (Auth::user() && $account->id === Auth::user()->id)
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mt-3 mb-0">
        <li class="breadcrumb-item active"><a href="#" style="text-decoration: none; color: black;">Profile</a></li>
        <li class="breadcrumb-item" aria-current="page" ><a href="{{ url('/profile/' . $account->id . '/edit') }}" style="text-decoration: none; color: grey;">Settings</a></li>
      </ol>
    </nav>
    @endif
    
    <h3 class="my-3">Profile</h3>

    <div class="row">
        <div id="userBar" class="col-4 border border-dark text-center m-5 p-0 text-center" style="min-height: 600px;">
            <div class="position-relative">
                <img src="/images/placeholder.png" class="img-fluid" width="500" height="250" alt="...">
                <img src="/images/profiles/{{ $account->user->profileImage->name }}" class="img-fluid rounded-circle position-absolute top-100 start-50 translate-middle" width="100" height="230" alt="...">
            </div>
            <h4 class="mt-5 pt-5">{{$account->name}}</h4>
            <hr class="px-5 mx-5">
            @if($account->description === null)
            <p class="pt-3 px-5 mx-5">Write your description...</p>
            @else
            <p class="pt-3 px-5 mx-5">{{$account->description}}</p>
            @endif
            @if (Auth::user() && $account->id === Auth::user()->id)
            <a href="{{ url('/profile/' . $account->id . '/edit') }}" type="button" class="btn btn-primary btn-lg">Edit Profile</a>
            @endif
        </div>
        <div class="col-8 d-flex flex-column m-5 p-0 w-50">
            @if(Auth::id() == $account->id)
            @if(Auth::user()->admin == null)
            <div class="">
                <a id="see-invites-button" type="button" class="btn btn-link fs-5 ms-0 ps-0" style="text-decoration: none; color: black;">Invites</a>
                <a id="see-tickets-button" type="button" class="btn btn-link fs-5" style="text-decoration: none; color:grey;">Tickets</a>
                <a id="see-events-button" type="button" class="btn btn-link fs-5" style="text-decoration: none; color:grey;">My Events</a>
            </div>
            <div id="content-events">
                <div id="perfil-invites" class="">
                    <div class="m-0 my-1 p-0 text-center">
                        @if(Auth::id() != $account->id)
                        <p class="mt-3 fs-4">These are not your invites</p>
                        @elseif(sizeof($account->user->invites) === 0)
                        <p class="mt-3 fs-4">There are no invites.</p>
                        @else
                            @foreach ($account->user->invites as $invite)
                            @include('partials.invite', ['event' => $invite->event, 'invite_id' => $invite->id])
                            @endforeach
                        @endif
                    </div>
                </div>
                <div id="perfil-events" class="visually-hidden">
                    @include('partials.ownedEvents', ['events' => $account->user->events])
                </div>
                <div id="perfil-tickets" class="visually-hidden">
                    @include('partials.tickets', ['tickets' => $account->user->tickets])
                </div>
            </div>
            @endif
            <div class="border border-grey m-0 mt-5 p-0">
                <div class="calendar">
                    <div class="d-flex flex-row justify-content-around align-items-center text-center month">
                        <div>
                            <button class="prev-month btn btn-link link-dark" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-caret-left-fill" viewBox="0 0 16 16">
                                    <path d="m3.86 8.753 5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z" />
                                </svg>
                            </button>
                        </div>
                        <div class="date mt-2">
                            <h3>November</h3>
                            <p>Mon Nov 14, 2022</p>
                        </div>
                        <div>
                            <button class="next-month btn btn-link link-dark" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 16 16">
                                    <path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="days d-flex flex-wrap m-0 p-4">
                        {{--@foreach($account->user->tickets as $ticket)
                            <div id="{{$ticket->event->start_date}}" class="border border-grey m-0 p-4" style="color: blue;">{{$ticket->event->get_start_date_day()}}</div>
                        @endforeach--}}
                    </div>
                </div>
            </div>
            @else
            <h3>Events</h3>
            @include('partials.ownedEvents', ['events' => $account->user->events])
            @endif
        </div>
    </div>
</div>
@endsection