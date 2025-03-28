<div class="card event-card mb-3">
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
                <!-- {{$event}} -->

                @foreach ($event->types() as $type)
                    <span class="badge text-bg-primary">{{$type['type_name']}}</span>
                @endforeach
                @if($event['date_end'])
                    <p class="card-text"><strong>{{ $event['date_start']->format("D, d M Y H:i") }} – {{ $event['date_end']->format("D, d M Y H:i") }}</strong></p>
                @else
                    <p class="card-text"><strong>{{ $event['date_start']->format("D, d M Y H:i") }}</strong></p>
                @endif
                <p class="card-text"><strong>{{ $event['location'] }}, {{ $event['city'] }}</strong></p>
                <p class="card-text text-muted"><span id="attendeeAmount{{ $event['id'] }}">{{ count($event->allAttendees) }}</span> going</p>
                <p class="card-text">{{ $event->short_description }} <a href="events/{{ $event['id'] }}"> See more</a></p>
                @if($event['owner_id'] != Auth::user()->id)
                    @if($event['attendees']->count() == 0)
                        @include('join-event-form')
                    @else
                        @include('leave-event-form')
                    @endif
                @endif
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
