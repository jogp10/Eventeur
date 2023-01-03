<div class="col card mb-3 me-5" style="max-width: 540px;">
    <div class="row g-0">
        <div class="col-md-4">
            <img src="/images/events/{{$event->coverImage->name}}" class="img-fluid" alt="...">
        </div>
        <div class="col-md-8 d-flex flex-row">
            <div class="card-body col-md-8">
                <a href="{{ url('/event/' . $event->id) }}">
                    <h5 class="card-title"> {{ $event->name }} </h5>
                </a>
                <p class="card-text"> Created By {{ $event->manager->account->name }}</p>
                <p class="card-text"><small class="text-muted">Last updated {{$event->updated_at}}</small></p>
            </div>
            <div class="col-md-4 mt-3 d-flex flex-column">
                <p>Reports: {{ count($event->reports) }}</p>
                <form class="pb-1" action="' + url + '/admin/event/' + event['id'] + '/event_settings" method="GET">
                <button type="submit" class="btn btn-warning">Edit</button></form>
                <form class="pb-1 mt-3 " action="' + url + '/admin/event/' + {{ $event->id }} + '/delete" method="POST">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="' + csrf + '">
                <button type="submit" class="btn btn-danger">Delete</button></form>
            </div>
        </div>
    </div>
</div>
