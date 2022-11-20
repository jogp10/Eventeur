<nav style="--bs-breadcrumb-divider: '|';" class="fs-3" aria-label="breadcrumb">
    <ol class="breadcrumb">
        @foreach (array_slice($pages, 0, count($pages)) as $page)
            @if($type == 0 && $page['title'] === "Invites")
                <li class="breadcrumb-item mb-0"><a class="mb-0 fs-3" style="text-decoration: none; color: black;" href="{{ url( $page['href'] ) }}">{{ $page['title'] }}</a></li>
            @elseif($type == 1 && $page['title'] === "Invites")
                <li class="breadcrumb-item mb-0"><a class="mb-0 fs-3" style="text-decoration: none; color: grey;" href="{{ url( $page['href'] ) }}">{{ $page['title'] }}</a></li>
            @elseif($type == 1 && $page['title'] === "Events")
                <li class="breadcrumb-item mb-0"><a class="mb-0 fs-3" style="text-decoration: none; color: black;" href="{{ url( $page['href'] ) }}">{{ $page['title'] }}</a></li>
            @else
                <li class="breadcrumb-item mb-0"><a class="mb-0 fs-3" style="text-decoration: none; color: grey;" href="{{ url( $page['href'] ) }}">{{ $page['title'] }}</a></li>
            @endif
         @endforeach
    </ol>
</nav>