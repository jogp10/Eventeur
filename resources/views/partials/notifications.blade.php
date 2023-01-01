<thead>
    <tr>
        <th>Notification</th>
        <th>Time</th>
        <th>Mark as read</th>
    </tr>
</thead>
<tbody
@foreach(Auth::user()->user->notifications as $notification)
<tr id="{{$notification->id}}" class="notification">
    @if($notification->inviteNotification !== null)
    @include('partials.invite-notification', ['invite' => $notification->inviteNotification->invite, 'notification' => $notification ])
    @elseif($notification->commentNotification !== null)
    @include('partials.comment-notification', ['comment' => $notification->commentNotification->comment, 'notification' => $notification])
    @endif
</tr>
@endforeach
</tbody>