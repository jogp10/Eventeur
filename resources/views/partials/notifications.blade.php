<thead>
    <tr>
        <th>Notification</th>
        <th>Time</th>
    </tr>
</thead>
<tbody @foreach(Auth::user()->user->latestNotifications() as $notification)
    <tr id="{{$notification->id}}" class="notification">
        @if($notification->inviteNotification !== null)
        @include('partials.invite-notification', ['invite' => $notification->inviteNotification->invite, 'notification' => $notification ])
        @elseif($notification->commentNotification !== null)
        @include('partials.comment-notification', ['comment' => $notification->commentNotification->comment, 'notification' => $notification])
        @endif
    </tr>
    @endforeach
    <!-- if there are no notifications -->
    @if(Auth::user()->user->latestNotifications()->count() == 0)
    <tr>
        <td colspan="2">
            <span>No new notifications</span>
        </td>
    </tr>
    @endif
</tbody>