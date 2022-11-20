@extends('layouts.app')

@section('title', '{{$event->name}}')

@section('content')
<div id="{{$event->id}}" class="event container-md d-flex flex-column w-100">
  <div class="d-flex flex-column border m-3 p-2 ps-4 rounded" style="min-height: 500px">
    <div class="event d-flex flex-row justify-content-between">
      <div class="pt-1">
        @include('partials.form', ['action' => 'up', 'id' => $event->id, 'type' => 'event'])
        <span class="d-flex justify-content-center">{{ $event->votes->count() }}</span>
        @include('partials.form', ['action' => 'down', 'id' => $event->id, 'type' => 'event'])
      </div>
      <div class="pt-2 ps-2 pe-2 pb-1 d-flex flex-column" style="max-width:800px">
        <h3 class="">{{ $event->name}}</h3>
        <div class="tags">
          @foreach($event->tags as $tag)
          <div class="badge bg-secondary">{{ $tag->name }}</div>
          @endforeach
        </div>
        <button type="button" class="btn ps-0 align-self-start text-decoration-none">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
          </svg>
          <span>Posted by {{$event->manager->account->name}}</span>
        </button>
        <h4 class="text-muted pb-3">{{ strtok($event->description, '.') }}</h4>
        <p class="text-break" style="max-width: 700px"> {{ substr($event->description, strpos($event->description, '.')+2) }}</p>
      </div>
      <div class="p-3 justify-content-center d-flex flex-column">
        <img src="../images/community-events.jpeg" class="rounded img-fluid m-0 p-0" height="300" width="400" alt="...">
        <div class="pt-2">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
            <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z" />
            <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
          </svg>
          <?php $maps = str_replace(' ', '%20', str_replace('#', ' ', str_replace(',', '%2C', $event->location))); ?>
          <a href="{{ 'https://www.google.com/maps/search/?api=1&query=' . $maps }}">{{$event->location}}</a>
        </div>
      </div>
    </div>
    <div class="d-flex flex-row mt-auto justify-content-between pb-3 ps-4 pe-4">
      <button type="button" class="btn btn-link text-decoration-none">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left" viewBox="0 0 16 16">
          <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
        </svg>
        <span>Comment</span>
      </button>
      <button type="button" class="btn btn-link text-decoration-none">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
          <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
          <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
        </svg>
        <span>{{ $event->start_date }}</span>
      </button>
      @can('update', $event)
      <button type="button" id="giveticket" class="btn btn-success text-decoration-none" data-bs-toggle="modal" data-bs-target="#giveticketModal">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-ticket-perforated" viewBox="0 0 16 16">
          <path d="M4 4.85v.9h1v-.9H4Zm7 0v.9h1v-.9h-1Zm-7 1.8v.9h1v-.9H4Zm7 0v.9h1v-.9h-1Zm-7 1.8v.9h1v-.9H4Zm7 0v.9h1v-.9h-1Zm-7 1.8v.9h1v-.9H4Zm7 0v.9h1v-.9h-1Z" />
          <path d="M1.5 3A1.5 1.5 0 0 0 0 4.5V6a.5.5 0 0 0 .5.5 1.5 1.5 0 1 1 0 3 .5.5 0 0 0-.5.5v1.5A1.5 1.5 0 0 0 1.5 13h13a1.5 1.5 0 0 0 1.5-1.5V10a.5.5 0 0 0-.5-.5 1.5 1.5 0 0 1 0-3A.5.5 0 0 0 16 6V4.5A1.5 1.5 0 0 0 14.5 3h-13ZM1 4.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v1.05a2.5 2.5 0 0 0 0 4.9v1.05a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-1.05a2.5 2.5 0 0 0 0-4.9V4.5Z" />
        </svg>
        <span>Give Ticket</span>
      </button>
      @else
      <button type="button" class="btn btn-link text-decoration-none">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-flag" viewBox="0 0 16 16">
          <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12.435 12.435 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A19.626 19.626 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a19.587 19.587 0 0 0 1.349-.476l.019-.007.004-.002h.001M14 1.221c-.22.078-.48.167-.766.255-.81.252-1.872.523-2.734.523-.886 0-1.592-.286-2.203-.534l-.008-.003C7.662 1.21 7.139 1 6.5 1c-.669 0-1.606.229-2.415.478A21.294 21.294 0 0 0 3 1.845v6.433c.22-.078.48-.167.766-.255C4.576 7.77 5.638 7.5 6.5 7.5c.847 0 1.548.28 2.158.525l.028.01C9.32 8.29 9.86 8.5 10.5 8.5c.668 0 1.606-.229 2.415-.478A21.317 21.317 0 0 0 14 7.655V1.222z" />
        </svg>
        <span>Report</span>
      </button>
      @endcan
      <button type="button" class="btn btn-primary text-decoration-none">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
          <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </svg>
        <span>Buy Tickets</span>
      </button>
      @if(Auth::check())
      <button type="button" id="invite" class="btn btn-primary text-decoration-none" data-bs-toggle="modal" data-bs-target="#inviteModal" style="background-color:#d1410c; border-color:#d1410c;">
        <i class="fa-regular fa-share-from-square"></i>
        <span>Invite</span>
      </button>
      @endif
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
        <form class="d-none d-sm-flex w-20 align-self-center form-inline w-100">
          <input type="text" class="form-control" id="searchuser_invite" name="query" placeholder="Search people" aria-label="Search" aria-describedby="button-addon2" value="">
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
<div class="modal fade" tabindex="-1" id="giveticketModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header d-flex flex-row">
        <form class="d-none d-sm-flex w-20 align-self-center form-inline w-100">
          <input type="text" class="form-control" id="searchuser_ticket" name="query" placeholder="Search people" aria-label="Search" aria-describedby="button-addon2" value="">
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
        <button id="send" type="button" class="btn btn-primary align-self-end m-1">Send Tickets</button>
      </div>
    </div>
  </div>
</div>

@endsection