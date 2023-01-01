@foreach(Auth::user()->user->notifications as $notification)
<div id="{{$notification->id}}">
    @if($notification->inviteNotification !== null)
    @include('partials.invite-notification')
    @elseif($notification->commentNotification !== null)
    @include('partials.comment-notification')
    @endif
</div>
@endforeach