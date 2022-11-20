<div class="row border border-dark my-2 mx-0 rounded" data-id="{{$event->id}}">
    <div class="container">
        <div class="row">
            @if($event->user_id == Auth::id())
            <div class="col-3 align-self-center">
                <h3><a class="fs-5" style="text-decoration: none; color: black;" href="{{ url('/event') . '/' . $event->id }}">{{$event->name}}</a></h3>
            </div>
            <div class="col-9 align-self-center">
                <p id="invite-event-description" class="fs-6 align-self-center mb-0">{{$event->description}}</p>
            </div>
            @else
            <div class="col-3 align-self-center">
                <h3><a class="fs-5" style="text-decoration: none; color: black;" href="{{ url('/event') . '/' . $event->id }}">{{$event->name}}</a></h3>
            </div>
            <div class="col-7 text-center align-self-center">
                <p id="invite-event-description" class="fs-6 align-self-center mb-0">{{$event->description}}</p>
            </div>
            <div class="col-2 align-self-center">
                <a href="" type="button" class="btn btn-success mb-2 mt-1">Accept</a>
                <a href="" type="button" class="btn btn-danger mt-0 mb-1">Ignore</a>
            </div>
            @endif
        </div>
    </div>
        
    
    
</div>