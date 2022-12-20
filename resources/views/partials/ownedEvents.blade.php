<div class="m-0 my-1 p-0 text-center">
    @if(sizeof($events) === 0)
        <p class="mt-3 fs-4">I don't have any events created.</p>
    @elseif(sizeof($events) == 1)
        <section id="cards">
            @each('partials.invite', $events, 'event')
        </section>
    @else
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($events as $event)
            @if($loop->index === 0)
                <div class="carousel-item active">
                    <section id="cards">
                    @include('partials.invite', ['event' => $event])
                    </section>
                </div>
            @else
                <div class="carousel-item">
                    <section id="cards">
                    @include('partials.invite', ['event' => $event])
                    </section>
                </div>
            @endif
            @endforeach
        </div>
        <div class="container mt-0 pt-0">
            <div class="row border border-grey border-rouded bg-green">
                <p class="fs-5">...</p>
            </div>  
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="">Next</span>
        </button>
    </div>
    @endif
</div>
