<div class="comment-section p-2">
  <div class="box border rounded p-3 ps-4 d-flex flex-row justify-content-start" data-id="{{$comment->id}}">
    <div class="pe-2">
      <img src="/images/profiles/{{$comment->user->profileImage->name}}" class="rounded-circle img-fluid m-0 p-0" height="80" width="120" alt="...">
    </div>
    <div class="flex-fill" style="width: 40rem;">
      <h4 style="margin-bottom: 0rem;">{{$comment->user->account->name}}</h4>
      <p class="text-muted" style="margin-left: 0.5rem;">@if ($comment->created_at != $comment->updated_at) edited @endif</p>
      <p>{{ $comment->content }}</p>
      <div class="d-flex flex-row">
        <div class="d-flex flex-row">
          @include('partials.form', ['action' => 'up', 'id' => $comment->id, 'type' => 'comment'])
          <span class="" style="line-height:38px;">{{ $comment->votes->count() }}</span>
          @include('partials.form', ['action' => 'down', 'id' => $comment->id, 'type' => 'comment'])
        </div>
        @if (Auth::id() == $comment->user_id)
        <button type="button" class="col btn btn-link text-decoration-none" style="text-decoration: none;color: black;">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
          </svg>
          <span>Edit</span>
        </button>
        @endif
        @if (Auth::check() && (Auth::id() == $comment->user_id || (Auth::user()->user->tickets && Auth::user()->user->tickets->where('event_id', $comment->event_id)->first()) || (Auth::user()->user->events && Auth::user()->user->events->where('event_id', $comment->event_id)->first())))
        <button id="{{$comment->id}}" type="button" class="event_comment col btn btn-link" style="text-decoration: none;color: black;">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left" viewBox="0 0 16 16">
            <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
          </svg>
          <span>Reply</span>
        </button>
        @endif
        <button type="button" class="col btn btn-link" style="text-decoration: none;flex-grow: 2;color: black;">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
            <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
          </svg>
          <span>{{$comment->created_at}}</span>
        </button>
        @if(Auth::check() && Auth::id() != $comment->user_id)
        <button type="button" class="col btn btn-link" style="text-decoration: none;color: black;">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-flag" viewBox="0 0 16 16">
            <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12.435 12.435 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A19.626 19.626 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a19.587 19.587 0 0 0 1.349-.476l.019-.007.004-.002h.001M14 1.221c-.22.078-.48.167-.766.255-.81.252-1.872.523-2.734.523-.886 0-1.592-.286-2.203-.534l-.008-.003C7.662 1.21 7.139 1 6.5 1c-.669 0-1.606.229-2.415.478A21.294 21.294 0 0 0 3 1.845v6.433c.22-.078.48-.167.766-.255C4.576 7.77 5.638 7.5 6.5 7.5c.847 0 1.548.28 2.158.525l.028.01C9.32 8.29 9.86 8.5 10.5 8.5c.668 0 1.606-.229 2.415-.478A21.317 21.317 0 0 0 14 7.655V1.222z" />
          </svg>
          <span>Report</span>
        </button>
        @endif
        @if(Auth::check() && Auth::id() == $comment->user_id)
        <form action="{{ route('deleteComment', ['id' => $comment->id]) }}" method="POST">
          @csrf
          @method('DELETE')
          <input type="hidden" name="comment_id" value="{{$comment->id}}">
          <button type="submit" class="col btn btn-danger btn-link" style="text-decoration: none;color: black;">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16" style="color: black;">
              <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"></path>
            </svg>
          </button>
        </form>
        @endif
      </div>
    </div>
  </div>
  <div style="margin-left:10rem">
    <div id="comment_{{ $comment->id }}_form" class="textarea-container comment-form mt-2 d-none">
      <form method="POST" action="{{ route( 'answer' ) }}" class="d-flex flex-column align-items-end">
        @csrf
        <input type="hidden" name="comment_id" value="{{ $comment->id }}">
        <textarea name="content" class="w-100 form-control" cols="60" rows="5" placeholder="Escreva aqui o seu comentário..."></textarea>
        <button type="submit" class="btn btn-primary btn-lg float-end">Enviar</button>
      </form>
    </div>
    @foreach ($comment->answers as $reply)
    <div class="answer box border rounded mt-2 p-3 ps-4 d-flex flex-row justify-content-start" data-id="{{$reply['id']}}" style="">
      <div class="pe-2">
        <img src="/images/profiles/{{$comment->user->profileImage->name}}" class="rounded-circle img-fluid m-0 p-0" height="80" width="120" alt="...">
      </div>
      <div class="flex-fill">
        <h4 style="margin-bottom: 0rem;">{{$reply->user->account->name}}</h4>
        <p class="text-muted" style="margin-left: 0.5rem;">@if ($reply->created_at != $reply->updated_at) edited @endif</p>
        <p>{{$reply->content}}</p>

        <div class="d-flex flex-row">
          <div class="d-flex flex-row justify-content-between">
            @include('partials.form', ['action' => 'up', 'id' => $reply->id, 'type' => 'answer'])
            <span class="" style="line-height:38px;">{{ $reply->votes->count() }}</span>
            @include('partials.form', ['action' => 'down', 'id' => $reply->id, 'type' => 'answer'])
          </div>
          @if (Auth::id() == $reply->user_id)
          <button type="button" class="col btn btn-link" style="text-decoration: none;color: black;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
              <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
            </svg>
            <span>Edit</span>
          </button>
          @endif
          <button type="button" class="col btn btn-link" style="text-decoration: none;flex-grow: 2;color: black;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
              <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
              <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
            </svg>
            <span>{{$reply->created_at}}</span>
          </button>
          @if (Auth::check() && Auth::id() != $reply->user_id)
          <button type="button" class="col btn btn-link" style="text-decoration: none;color: black;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-flag" viewBox="0 0 16 16">
              <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12.435 12.435 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A19.626 19.626 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a19.587 19.587 0 0 0 1.349-.476l.019-.007.004-.002h.001M14 1.221c-.22.078-.48.167-.766.255-.81.252-1.872.523-2.734.523-.886 0-1.592-.286-2.203-.534l-.008-.003C7.662 1.21 7.139 1 6.5 1c-.669 0-1.606.229-2.415.478A21.294 21.294 0 0 0 3 1.845v6.433c.22-.078.48-.167.766-.255C4.576 7.77 5.638 7.5 6.5 7.5c.847 0 1.548.28 2.158.525l.028.01C9.32 8.29 9.86 8.5 10.5 8.5c.668 0 1.606-.229 2.415-.478A21.317 21.317 0 0 0 14 7.655V1.222z" />
            </svg>
            <span>Report</span>
          </button>
          @endif
          @if(Auth::check() && Auth::id() == $reply->user_id)
          <form action="{{ route('deleteAnswer', ['id' => $reply->id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" name="answer_id" value="{{$reply->id}}">
            <button type="submit" class="col btn btn-danger btn-link" style="text-decoration: none;color: black;">
              <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16" style="color: black;">
                <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"></path>
              </svg>
            </button>
          </form>
          @endif
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>