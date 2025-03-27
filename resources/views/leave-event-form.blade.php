<form id="leave-form{{ $event['id'] }}" method="POST" class="center" action="{{ url('events/' . $event['id'] . '/attendees') }}">
    @csrf
    <input type="hidden" id="user_id{{ $event['id'] }}" name="user_id" value="{{ Auth::user()->id }}">
    <input type="hidden" id="event_id{{ $event['id'] }}" name="event_id" value="{{ $event['id'] }}">
    <input type="hidden" id="attendee_id{{ $event['id'] }}" name="attendee_id" value="{{ $event['attendees'][0]['id'] }}">
    <input type="hidden" id="leaveroute{{ $event['id'] }}" name="leaveroute" value="{{ route('events.attendees.destroy', [$event['id'], $event['attendees'][0]['id']]) }}">
    <button id="leave{{ $event['id'] }}" type="submit" class="btn btn-danger leaveEventBtn">
        Leave
    </button>
</form>
