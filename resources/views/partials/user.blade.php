<div class="col card mb-3 me-5" style="max-width: 540px;">
    <div class="row g-0">
        <div class="col-md-4">
            <img src="/images/perfil.png" class="rounded-circle img-fluid rounded-start" alt="...">
        </div>
        <div class="col-md-8 d-flex flex-row">
            <div class="card-body col-md-8">
                <a href="{{ url('/profile/' . $user->id) }}">
                    <h5 class="card-title"> {{$user->name}} </h5>
                </a>
                <p class="card-text"> {{ $user->email }}</p>
                <p class="card-text"><small class="text-muted">Last updated {{$user->updated_at}}</small></p>
            </div>
            <div class="col-md-4 d-flex flex-column justify-content-center">
                <p>Reports: {{$user->user->reports->count()}}</p>
                @if($user->admin)<p> Bans: {{$user->admin->bans->count()}} </p>@endif
                <form class="pb-1" action="{{ url('/admin/users/' . $user->id . '/edit') }}" method="GET">
                    <button type="submit" class="btn btn-warning">Edit</button>
                </form>
                @if ($user->banned)
                <form class="pb-1" action="{{ url('/admin/users/' . $user->id . '/unban') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Unban</button>
                </form>
                @else
                <form class="pb-1" action="{{ url('/admin/users/' . $user->id . '/ban') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Ban</button>
                </form>
                @endif
                <form class="pb-1" action="{{ url('/admin/users/' . $user->id . '/delete') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
