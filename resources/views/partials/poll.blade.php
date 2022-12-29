<section id="poll{{$poll->id}}" class="border border-grey rounded mb-2 w-50">
  <div class="row mx-0 px-0">
    @php
      $aswered = false
    @endphp
    <h4 class="fw-bold text-center mt-3"></h4>
    <form class=" bg-white px-4" method="POST" action="{{ route('votePoll', $poll->id) }}">
      @csrf
      <p class="fw-bold">{{$poll->question}}</p>
      @foreach($poll->pollOptions as $option)
      <div class="d-flex flex-row justify-content-between ms-3 form-check mb-2">
        <div>
          @if(Auth::user()->user->checkVotedOption($option->id))
          <input class="form-check-input" type="radio" name="pollOption" value="{{ $option->id }}" id="radioExample1" disable checked />
          @elseif(Auth::user()->user->checkIfVotedPoll($poll->id) || Auth::id() === $poll->event->manager->id)
          <input class="form-check-input" type="radio" name="pollOption" value="{{ $option->id }}" id="radioExample1" disabled />
          @else
          <input class="form-check-input" type="radio" name="pollOption" value="{{ $option->id }}" id="radioExample1" />
          @endif
          <label class="form-check-label" for="radioExample1">
          </label>
        </div>
        <p>{{ $option->votes }}</p>
      </div>
      @endforeach 
      @if(Auth::id() !== $poll->event->manager->id && !Auth::user()->user->checkIfVotedPoll($poll->id))
      <div id='${$poll->event->id}' class="text-end mb-2">
        <button id="submit-poll-vote" type="submit" class="btn btn-primary">Submit</button>
      </div>
      @endif
    </form>
  </div>
</section>