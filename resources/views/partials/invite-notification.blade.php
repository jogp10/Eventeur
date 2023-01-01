<td>
    <span>You we're invited to {{ $invite->event->name }}</span>
</td>
<td>
    <span>{{ $notification->created_at->diffForHumans() }}</span>
</td>
<td>
    <form action="{{ route('markAsRead', ['notification_id' => $notification->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <button type="submit" class="btn btn-primary">Mark as read</button>
    </form>
</td>