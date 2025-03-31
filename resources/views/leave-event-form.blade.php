<form id="leave-form{{ $event['id'] }}" method="POST" class="center" action="{{ url('events/' . $event['id'] . '/attendees') }}">
    @csrf
    <input type="hidden" id="leaveroute{{ $event['id'] }}" name="leaveroute" value="{{ route('events.attendees.destroy', [$event['id'], $event['attendees'][0]['id']]) }}">
    <button id="leave{{ $event['id'] }}" type="submit" class="btn btn-danger leaveEventBtn">
        Leave
    </button>
</form>
