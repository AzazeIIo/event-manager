@if(count($events) == 0)
<p>Nothing to show right now.</p>
@else
    @foreach ($events as $event)
        @include('event-card')
    @endforeach
@endif
<div class="center">{{ $events->links() }}</div>
