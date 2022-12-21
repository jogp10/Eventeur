<section id="poll{{$poll->id}}" class="border border-grey rounded mb-2 w-50">
  <div class="row mx-0 px-0">
    <h4 class="fw-bold text-center mt-3"></h4>
    <form class=" bg-white px-4" method="POST" action="{{ route('votePoll', $poll->id) }}">
      @csrf
      <p class="fw-bold">{{$poll->question}}</p>
      @foreach($poll->pollOptions as $option)
      <div class="d-flex flex-row justify-content-between ms-3 form-check mb-2">
        <div>
          @if(Auth::id() === $poll->event->manager->id)
          <input class="form-check-input" type="radio" name="pollOption" value="{{ $option->id }}" id="radioExample1" disabled />
          @else
          <input class="form-check-input" type="radio" name="pollOption" value="{{ $option->id }}" id="radioExample1" />
          @endif
          <label class="form-check-label" for="radioExample1">
          {{ $option->description }}
          </label>
        </div>
        <p>{{$option->votes}}</p>
      </div>
      @endforeach
      <div class="text-end mb-2">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>
</section>