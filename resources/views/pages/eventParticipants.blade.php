@extends('layouts.app')


@section('content')
<div class="container-md">
    <h1 class="text-center m-3 mt-4">Event Settings</h1>
    <div class="row">
        <div class="col">
            <nav class="border-bottom border-3" style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                <ol class="breadcrumb ps-5 mb-2">
                    <li class="breadcrumb-item me-2"><a class="link-secondary text-decoration-none" href="{{ route('eventSettings', ['id' => $event->id]) }}">
                            <p class="m-0 fs-5">Settings</p>
                        </a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a class="link-dark text-decoration-none" href="{{ route('eventParticipants', ['id' => $event->id]) }}">
                            <p class="m-0 fs-5">Participants</p>
                        </a></li>
                </ol>
            </nav>
        </div>
    </div>


    <div class="row mt-5 ps-2">
        <div>
            <h5>Attendees</h5>
            @if($event->tickets->count() != 0)
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Tickets</th>
                        <th scope="col">Last Ticket bought at</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($event->tickets as $ticket)
                    <tr>
                        <td>{{$ticket->user->account->name}}</td>
                        <td>{{$ticket->user->account->email}}</td>
                        <td>{{$ticket->num_of_tickets}}</td>
                        <td>{{$ticket->updated_at}}</td>
                        <td>
                            <form class="pb-1" action="{{ route('deleteTicket', ['id' => $ticket->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Remove Ticket</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p class="p-3 fs-5">No tickets bought yet.</p>
            @endif
        </div>
        @if($event->invites->count() != 0)
        <div>
            <h5>Invite pending</h5>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Invited in</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($event->invites as $invite)
                    <tr>
                        <td>{{$invite->user->account->name}}</td>
                        <td>{{$invite->user->account->email}}</td>
                        <td>{{$invite->updated_at}}</td>
                        <td>
                            <form class="pb-1" action="{{ route('deleteInvite', ['id' => $invite->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Cancel Invite</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection