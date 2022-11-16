<form @if ($type != 'event') class="col" @endif method="GET" action="{{ action('VoteController@vote') }}" style="display: inline;padding: 0rem;">
    <input type="hidden" name="action" value="{{$action}}">
    <input type="hidden" name="id" value="{{$id}}">
    <input type="hidden" name="type" value="{{$type}}">
    <input type="hidden" name="user_id" value="{{Auth::id()}}">
    <button type="submit" class="btn btn-link ps-0 ms-0">

        @if ($action == 'up')
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z" />
        </svg>

        @else
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
        </svg>
        @endif
    </button>
</form>
