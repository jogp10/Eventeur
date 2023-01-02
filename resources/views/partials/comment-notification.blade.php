<td>
    <span>{{ $comment->user->name }} commented on {{ $comment->event->name }}</span>
</td>
<td>
    <span>{{ $notification->created_at->diffForHumans() }}</span>
</td>