<td scope="row">
    <span>{{ $comment->user->account->name }} commented on {{ $comment->event->name }}</span>
</td>
<td>
    <span>{{ $notification->created_at->diffForHumans() }}</span>
</td>