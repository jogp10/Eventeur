<div class="row border border-dark my-2 mx-0 rounded" data-id="{{$event->id}}">
    <div class="container align-self-center">
        <div class="row gx-0">
            @if($event->user_id == Auth::id())
            <div class="col-4 align-self-center m-0">
                <h3><a class="fs-5" style="text-decoration: none; color: black;" href="{{ url('/event') . '/' . $event->id }}">{{$event->name}}</a></h3>
            </div>
            <div class="col-8 m-0">
                <p id="invite-event-description" class="fs-6 mb-0">{{strstr($event->description, '.', true)}}</p>
            </div>
            @else
            <div class="col-4 align-self-center m-0">
                <h3><a class="fs-5" style="text-decoration: none; color: black;" href="{{ url('/event') . '/' . $event->id }}">{{$event->name}}</a></h3>
            </div>
            <div class="col-6 align-self-center m-0">
                <p id="invite-event-description" class="fs-6 align-self-center mb-0">{{strstr($event->description, '.', true)}}</p>
            </div>
            <div class="col-2 align-self-center m-0">
                @if(isset($invite_id))
                <a href="{{ route('AcceptInvitation', [Auth::id(), $invite_id]) }}" type="button" class="btn btn-success mb-2 mt-1">Accept</a>
                <a href="{{ route('IgnoreInvitation', [Auth::id(), $invite_id]) }}" type="button" class="btn btn-danger mt-0 mb-1">Ignore</a>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>