@foreach ($events as $event)
    @include('event-card')
@endforeach
<div class="center">{{ $events->links() }}</div>
