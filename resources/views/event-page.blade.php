@if(count($events) == 0)
<p id="emptyPage">Nothing to show right now.</p>
@else
    @foreach ($events as $event)
        @include('event-card')
    @endforeach
@endif
<div id="eventPagination" class="center">{{ $events->links() }}</div>
