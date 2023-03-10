<div class="row border border m-5 rounded" data-id="{{$event->id}}">
    <div class="eventHome d-flex align-items-center justify-content-start">
        <div class="d-flex flex-column align-self-start">
            @include('partials.form', ['action' => 'up', 'id' => $event->id, 'type' => 'event'])
            <span class="d-flex justify-content-center">{{ $event->votes->count() }}</span>
            @include('partials.form', ['action' => 'down', 'id' => $event->id, 'type' => 'event'])
        </div>
        <div class="my-2 d-flex flex-fill flex-column justify-content-between align-self-stretch">
            <h3><a style="text-decoration: none; color: black;" href="{{ url('/event') . '/' . $event->id }}">{{$event->name}}</a></h3>
            <p class="mb-2">{{strstr($event->description, '.', true)}}</p>
            <div class="d-flex flex-row justify-content-between align-items-end">
                <div class="p-1" style="text-decoration: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left" viewBox="0 0 16 16">
                        <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                    </svg>
                    <span>{{ count($event->comments) }} Comment</span>
                </div>
                <a href="{{ route('profile', $event->manager->account->id ) }}" class="p-1" style="text-decoration: none;color:inherit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                    </svg>
                    <span>Posted by {{$event->manager->account->name}}</span>
                </a>
                <div class="p-1" style="text-decoration: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                    </svg>
                    <span>{{$event->start_date}}</span>
                </div>
            </div>
        </div>
        <div class="m-2" style="margin-left:auto">
            <img src="/images/events/{{$event->coverImage->name}}" class="img-fluid rounded" height="300" width="400" alt="..." style="max-width:321px">
        </div>
    </div>
</div>