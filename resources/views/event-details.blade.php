@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card">
                @if ($event['image'])
                <div class="card-header p-0">
                    <img src="{{ '/storage/' . $event['image'] }}" class="userimage img-fluid rounded-top" alt="...">
                </div>
                @endif
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-sm-8 col-12 order-sm-1 order-1">
                            <h5 class="card-title">{{ $event['name'] }}</h5>
                            @foreach ($event->types() as $type)
                                <span class="badge text-bg-primary">{{$type['type_name']}}</span>
                            @endforeach
                            @if($event['date_end'])
                                <p class="card-text"><strong>{{ $event['date_start']->format("D, d M Y H:i") }} – {{ $event['date_end']->format("D, d M Y H:i") }}</strong></p>
                            @else
                                <p class="card-text"><strong>{{ $event['date_start']->format("D, d M Y H:i") }}</strong></p>
                            @endif
                            <p class="card-text"><strong>{{ $event['location'] }}, {{ $event['city'] }}</strong></p>
                            <p class="card-text text-muted">{{ count($event->attendees) }} going</p>
                        </div>
                        <div class="col-sm-4 col-12 order-sm-2 order-3 center">
                            <form method="POST" action="{{ url('events/' . $event['id'] . '/attendees') }}">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="event_id" value="{{ $event['id'] }}">
                                <button type="submit" class="btn btn-primary mt-sm-0 mt-3">
                                    I'll be there
                                </button>
                            </form>
                        </div>
                        <p class="card-text order-sm-3 order-2 mt-3">
                            @foreach(explode(PHP_EOL, $event['description']) as $line )
                                {{ $line }} <br>
                            @endforeach
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
