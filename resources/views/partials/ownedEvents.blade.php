<div class="border border-grey m-0 my-1 p-0 text-center" style="min">
    @if(sizeof($events) === 0)
        <p class="mt-3 fs-4">I don't have any events created.</p>
    @else
    <!--Mudar isto(talvez?) e nao tenho a certeza se esta a funcionar. Na minha conta nao tenho invites.-->
    <section id="cards">
        @each('partials.invite', $events, 'event')
    </section>
    @endif
</div>