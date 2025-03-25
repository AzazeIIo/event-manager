@foreach ($events as $event)
    <div class="card mb-3">
        <div class="row g-0">
            <div class="col-lg-5 center">
                <img src="{{ '/storage/' . $event['image'] }}" class="userimage img-fluid rounded" alt="...">
            </div>
            <div class="col-lg-7">
                <div class="card-body">
                    <h5 class="card-title">{{ $event['name'] }}</h5>
                    @foreach (json_decode($event['type'], true) as $type)
                        <span class="badge text-bg-primary">{{$event->getType($type)}}</span>
                    @endforeach
                    <p class="card-text"><strong>{{ $event['date_start']->format("D, d M Y H:i") }} – {{ $event['date_end']->format("D, d M Y H:i") }}</strong></p>
                    <p class="card-text"><strong>{{ $event['location'] }}, {{ $event['city'] }}</strong></p>
                    <p class="card-text text-muted">{{ count($event->attendees) }} going</p>
                    <p class="card-text">{{ $event->short_description }} <a href="events/{{ $event['id'] }}"> See more</a></p>
                    <form method="POST" class="center" action="{{ url('events/' . $event['id'] . '/attendees') }}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="event_id" value="{{ $event['id'] }}">
                        <button type="submit" class="btn btn-primary">
                            I'll be there
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @if (Auth::check() && $includeform)
            <div class="dropdown-center center options">
                <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="options.png" alt="Options">
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Visibility</a></li>
                    <li><a class="dropdown-item" href="#">Edit</a></li>
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
@endforeach
<div class="center">{{ $events->links() }}</div>
