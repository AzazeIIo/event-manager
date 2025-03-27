<form id="join-form{{ $event['id'] }}" method="POST" class="center" action="{{ url('events/' . $event['id'] . '/attendees') }}">
    @csrf
    <input type="hidden" id="user_id{{ $event['id'] }}" name="user_id" value="{{ Auth::user()->id }}">
    <input type="hidden" id="event_id{{ $event['id'] }}" name="event_id" value="{{ $event['id'] }}">
    <input type="hidden" id="joinroute{{ $event['id'] }}" name="joinroute" value="{{ url('events/' . $event['id'] . '/attendees') }}">
    <button id="join{{ $event['id'] }}" type="submit" class="btn btn-primary joinEventBtn">
        Join
    </button>
</form>
