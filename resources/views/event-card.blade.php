<div class="card mb-3">
    <div id="{{$event['id']}}" class="row g-0">
        @if($event['image'])
            <div class="col-lg-5 center">
                <img src="{{ '/storage/' . $event['image'] }}" class="userimage img-fluid rounded" alt="...">
            </div>
            @if($includeform)
                <div class="col-lg-6">
            @else
                <div class="col-lg-7">
            @endif
        @elseif($includeform)
            <div class="col-lg-11">
        @else
            <div class="col-lg-12">
        @endif
            <div class="card-body">
                <h5 class="card-title">{{ $event['name'] }}</h5>
                @foreach ($event->types() as $type)
                    <span class="badge text-bg-primary">{{$type['type_name']}}</span>
                @endforeach
                <p class="card-text"><strong>{{ $event['date_start']->format("D, d M Y H:i") }} – {{ $event['date_end']->format("D, d M Y H:i") }}</strong></p>
                <p class="card-text"><strong>{{ $event['location'] }}, {{ $event['city'] }}</strong></p>
                <p id="attendeeAmount{{ $event['id'] }}" class="card-text text-muted">{{ count($event->attendees) }} going</p>
                <p class="card-text">{{ $event->short_description }} <a href="events/{{ $event['id'] }}"> See more</a></p>
                <form method="POST" class="center" action="{{ url('events/' . $event['id'] . '/attendees') }}">
                    @csrf
                    <input type="hidden" id="user_id{{ $event['id'] }}" name="user_id" value="{{ Auth::user()->id }}">
                    <input type="hidden" id="event_id{{ $event['id'] }}" name="event_id" value="{{ $event['id'] }}">
                    <input type="hidden" id="joinroute{{ $event['id'] }}" name="joinroute" value="{{ url('events/' . $event['id'] . '/attendees') }}">
                    <button id="join{{ $event['id'] }}" type="submit" class="btn btn-primary joinEventBtn">
                        I'll be there
                    </button>
                </form>
            </div>
        </div>
    </div>
    @if (Auth::check() && $includeform)
        @include('edit-event-form')
        <div class="dropdown-center center options">
            <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="options.png" alt="Options">
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Visibility</a></li>
                <li>
                    <button class="btn btn-primary dropdown-item editEventBtn" id="edit{{ $event['id'] }}">Edit</button>
                </li>
                <li>
                    <form class="center">
                        @csrf
                        <input type="hidden" name="_route" id="delroute{{ $event['id'] }}" value="{{ route('events.destroy', [$event['id']]) }}">
                        <button type="submit" id="del{{ $event['id'] }}" data-bs-toggle="modal" data-bs-target="#removeModal" class="btn btn-primary dropdown-item deleteEventBtn">
                            Delete
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    @endif
</div>
