@extends('layouts.app')

@section('title', '{{$event->name}}')

@section('content')
<div id="{{$event->id}}" class="event container-md d-flex flex-column" style="width:100%">
  <div class="d-flex flex-column border border-dark m-3 p-2 ps-4 pe-4 rounded" style="min-height: 500px">
    <div class="event d-flex flex-row justify-content-between">
      <div class="p-2 ps-4">
        @include('partials.form', ['action' => 'up', 'id' => $event->id, 'type' => 'event'])
        <span class="d-flex justify-content-center">{{ $event->votes->count() }}</span>
        @include('partials.form', ['action' => 'down', 'id' => $event->id, 'type' => 'event'])
      </div>
      <div class="p-2 pb-1 d-flex flex-column">
        <h3 class="">{{ $event->name}}</h3>
        <div class="tags">
          @foreach($event->tags as $tag)
          <div class="badge bg-secondary">{{ $tag->name }}</div>
          @endforeach
        </div>
        <button type="button" class="btn ps-0 align-self-start" style="text-decoration: none;">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
          </svg>
          <span>Posted by {{$event->manager->account->name}}</span>
        </button>
        <h4 class="text-muted pb-3">{{ strtok($event->description, '.') }}</h4>
        <p class=""> {{ substr($event->description, strpos($event->description, '.')+2) }}</p>
      </div>
      <div class="p-2 pt-5">
        <img src="../images/community-events.jpeg" class="img-fluid m-0 p-0" height="300" width="400" alt="...">
      </div>
    </div>
    <div class="d-flex flex-row mt-auto justify-content-between pb-3 ps-4 pe-4">
      <button type="button" class="btn btn-link" style="text-decoration: none;">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left" viewBox="0 0 16 16">
          <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
        </svg>
        <span>Comment</span>
      </button>
      <button type="button" class="btn btn-link" style="text-decoration: none;">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
          <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
          <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
        </svg>
        <span>{{ $event->start_date }}</span>
      </button>
      @if(Auth::id() == $event->user_id)
      @else
      <button type="button" class="btn btn-link" style="text-decoration: none;">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-flag" viewBox="0 0 16 16">
          <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12.435 12.435 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A19.626 19.626 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a19.587 19.587 0 0 0 1.349-.476l.019-.007.004-.002h.001M14 1.221c-.22.078-.48.167-.766.255-.81.252-1.872.523-2.734.523-.886 0-1.592-.286-2.203-.534l-.008-.003C7.662 1.21 7.139 1 6.5 1c-.669 0-1.606.229-2.415.478A21.294 21.294 0 0 0 3 1.845v6.433c.22-.078.48-.167.766-.255C4.576 7.77 5.638 7.5 6.5 7.5c.847 0 1.548.28 2.158.525l.028.01C9.32 8.29 9.86 8.5 10.5 8.5c.668 0 1.606-.229 2.415-.478A21.317 21.317 0 0 0 14 7.655V1.222z" />
        </svg>
        <span>Report</span>
      </button>
      @endif
      <button type="button" class="btn btn-primary" style="text-decoration: none; ">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
          <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </svg>
        <span>Buy Tickets</span>
      </button>
      <button type="button" id="invite" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#inviteModal" style="text-decoration: none; background-color:#d1410c; border-color:#d1410c;">
        <i class="fa-regular fa-share-from-square"></i>
        <span>Invite</span>
      </button>
    </div>
  </div>
  <div id="comments" class="m-3" style="margin-left: 7rem !important">
    @each('partials.comment', $event->comments, 'comment')
  </div>
</div>
<div class="modal fade" tabindex="-1" id="inviteModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header d-flex flex-row">
        <form class="d-none d-sm-flex w-20 align-self-center form-inline" action="" style="width:100%">
          <input type="text" class="form-control" id="searchuser" name="query" placeholder="Search people" aria-label="Search" aria-describedby="button-addon2" value="">
          <button class="btn btn-outline-secondary" type="submit" id="button-addon2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
              <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
            </svg>
          </button>
        </form>
      </div>
      <div class="modal-body p-1 d-flex flex-column flex-1" style="overflow: auto; max-height:400px">
        <div class="d-flex flex-column" style="min-height:min-content">
          <div class="userCard d-flex flex-row p-0 pb-1">
            <table class="w-100">
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer p-0">
        <button id="send" type="button" class="btn btn-primary align-self-end m-1">Send Invites</button>
      </div>
    </div>
  </div>
</div>


@endsection