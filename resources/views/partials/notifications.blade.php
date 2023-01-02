<thead class="thead-dark d-flex">
    <tr class="justify-content-between d-flex flex-fill">
        <th scope="col" style="width:70%">Notification</th>
        <th scope="col" style="width:30%">Time</th>
    </tr>
</thead>
<tbody>
    @foreach(Auth::user()->user->latestNotifications() as $notification)
    <tr id="{{$notification->id}}" class="notification">
        @if($notification->inviteNotification !== null)
        @include('partials.invite-notification', ['invite' => $notification->inviteNotification->invite, 'notification' => $notification ])
        @elseif($notification->commentNotification !== null)
        @include('partials.comment-notification', ['comment' => $notification->commentNotification->comment, 'notification' => $notification])
        @endif
    </tr>
    @endforeach
    @if(Auth::user()->user->latestNotifications()->count() == 0)
    <tr>
        <td colspan="2">
            <span style="top:50%;left:50%;position:absolute;transform:translate(-50%,-50%)">No new notifications</span>
        </td>
    </tr>
    @endif
</tbody>