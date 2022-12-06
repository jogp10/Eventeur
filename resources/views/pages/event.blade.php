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
      <div class="pt-2 ps-2 pe-2 pb-1 d-flex flex-column flex-fill" style="max-width:800px">
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
        <img src="/images/community-events.jpeg" class="rounded img-fluid m-0 p-0" height="300" width="400" alt="...">
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
    <div class="d-flex flex-row mt-auto justify-content-between align-items-end pb-3 ps-4 pe-4">
      <button type="button" class="btn btn-link" style="text-decoration: none; color: black;">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
          <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
          <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
        </svg>
        <span>{{ $event->start_date }}</span>
      </button>
      @can('create', [App\Models\Comment::class, $event])
      <button type="button" id="comment-button" class="btn btn-link" style="text-decoration: none; color: black;">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left" viewBox="0 0 16 16">
          <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
        </svg>
        <span>Comment</span>
      </button>
      @endcan
      @if(Auth::check())
      <button type="button" id="invite" class="btn btn-primary text-decoration-none" data-bs-toggle="modal" data-bs-target="#inviteModal" style="background-color:#d1410c; border-color:#d1410c;">
        <i class="fa-regular fa-share-from-square"></i>
        <span>Invite</span>
      </button>
      @endif
      @if(Auth::check() && Auth::user()->user->tickets->where('event_id', $event->id)->count() > 0)
      <form action="{{ route('deleteTicket', ['id' => Auth::user()->user->tickets->where('event_id', $event->id)[0]->id]) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-secondary text-decoration-none">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z" />
            <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
          </svg>
          <span>Leave event</span>
        </button>
      </form>
      @endif
      @can('update', $event)
      <button type="button" id="giveticket" class="btn btn-success text-decoration-none" data-bs-toggle="modal" data-bs-target="#giveticketModal">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-ticket-perforated" viewBox="0 0 16 16">
          <path d="M4 4.85v.9h1v-.9H4Zm7 0v.9h1v-.9h-1Zm-7 1.8v.9h1v-.9H4Zm7 0v.9h1v-.9h-1Zm-7 1.8v.9h1v-.9H4Zm7 0v.9h1v-.9h-1Zm-7 1.8v.9h1v-.9H4Zm7 0v.9h1v-.9h-1Z" />
          <path d="M1.5 3A1.5 1.5 0 0 0 0 4.5V6a.5.5 0 0 0 .5.5 1.5 1.5 0 1 1 0 3 .5.5 0 0 0-.5.5v1.5A1.5 1.5 0 0 0 1.5 13h13a1.5 1.5 0 0 0 1.5-1.5V10a.5.5 0 0 0-.5-.5 1.5 1.5 0 0 1 0-3A.5.5 0 0 0 16 6V4.5A1.5 1.5 0 0 0 14.5 3h-13ZM1 4.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v1.05a2.5 2.5 0 0 0 0 4.9v1.05a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-1.05a2.5 2.5 0 0 0 0-4.9V4.5Z" />
        </svg>
        <span>Give Ticket</span>
      </button>
      <a href="{{ route( 'eventSettings', $event->id ) }}" type="button" class="btn btn-link" style="text-decoration: none; color: black;">
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25 " fill="currentColor" class="bi bi-gear " viewBox="0 0 16 16">
          <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z" />
          <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z" />
        </svg>
      </a>
      @else
      <button type="button" class="btn btn-link" style="text-decoration: none; color: black;">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-flag" viewBox="0 0 16 16">
          <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12.435 12.435 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A19.626 19.626 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a19.587 19.587 0 0 0 1.349-.476l.019-.007.004-.002h.001M14 1.221c-.22.078-.48.167-.766.255-.81.252-1.872.523-2.734.523-.886 0-1.592-.286-2.203-.534l-.008-.003C7.662 1.21 7.139 1 6.5 1c-.669 0-1.606.229-2.415.478A21.294 21.294 0 0 0 3 1.845v6.433c.22-.078.48-.167.766-.255C4.576 7.77 5.638 7.5 6.5 7.5c.847 0 1.548.28 2.158.525l.028.01C9.32 8.29 9.86 8.5 10.5 8.5c.668 0 1.606-.229 2.415-.478A21.317 21.317 0 0 0 14 7.655V1.222z" />
        </svg>
        <span>Report</span>
      </button>
      @endcan
      @can('delete', $event)
      <form method="POST" action="{{ route( 'deleteEvent', ['id' => $event->id] ) }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-link btn-outline-danger" style="text-decoration: none;">
          <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16" style="color: black;">
            <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
          </svg>
        </button>
      </form>
      @endcan
    </div>
  </div>
  <div id="comments" class="m-3 " style="margin-left: 7rem !important">
    @can('create', [App\Models\Comment::class, $event])
    <div id="comment_form" class="textarea-container comment-form m-2 d-none">
      <form method="POST" action="{{ route( 'comment' ) }}" class="d-flex flex-column align-items-end">
        @csrf
        <input type="hidden" name="event_id" value="{{ $event->id }}">
        <textarea name="content" class="w-100 form-control" id="comment-content" cols="60" rows="5" placeholder="Escreva aqui o seu comentário..."></textarea>
        <button type="submit" class="btn btn-primary btn-lg float-end">Enviar</button>
      </form>
    </div>
    @endcan
    @each('partials.comment', $event->comments, 'comment', )
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
        <button id="sendInvite" type="button" class="btn btn-primary align-self-end m-1" data-bs-dismiss="modal">Send Invites</button>
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
        <button id="sendTicket" type="button" class="btn btn-primary align-self-end m-1" data-bs-dismiss="modal">Send Tickets</button>
      </div>
    </div>
  </div>
</div>

<style>
  .textarea-container {
    position: relative;
  }

  .textarea-container textarea {
    width: 100%;
    height: 100%;
    box-sizing: border-box;
  }

  .textarea-container button {
    position: absolute;
    top: 100%;
    right: 1%;
    transform: translateY(-110%);
  }
</style>
@endsection