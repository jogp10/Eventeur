<div class="m-0 my-1 p-0 text-center">
    @if(sizeof($tickets) === 0)
        <p class="mt-3 fs-4">I don't own any tickets.</p>
    @elseif(sizeof($tickets) == 1)
        <section id="cards">
            @foreach($tickets as $ticket)
                @include('partials.invite', ['event' => $ticket->event])
            @endforeach
    @else
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel" style="">
        <div class="carousel-inner">
            @foreach($tickets as $ticket)
            @if($loop->index === 0)
                <div class="carousel-item active">
                    <section id="cards">
                    @include('partials.invite', ['event' => $ticket->event])
                    </section>
                </div>
            @else
                <div class="carousel-item">
                    <section id="cards">
                    @include('partials.invite', ['event' => $ticket->event])
                    </section>
                </div>
            @endif
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="false"></span>
            <span class="">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="false"></span>
            <span class="">Next</span>
        </button>
    </div>
    @endif
</div>
