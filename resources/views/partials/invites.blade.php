<div class="border border-grey m-0 my-1 p-0 text-center">
    @if(sizeof($invites) === 0)
        <p class="mt-3 fs-4">There are no invites.</p>
    @else
    <!--Mudar isto(talvez?) e nao tenho a certeza se esta a funcionar. Na minha conta nao tenho invites.-->
    <section id="cards">
        @foreach ($invites as $invite)
            @include('partials.invite', ['event' => $invite->event, 'invite_id' => $invite->id])
        @endforeach
    </section>
    @endif
</div>