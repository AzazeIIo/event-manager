@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card">
                @if ($event['image'])
                <div class="card-header p-0">
                    <img src="{{ '/storage/' . $event['image'] }}" data-bs-toggle="modal" data-bs-target="#imageModal" class="userimage img-fluid rounded-top" alt="...">
                </div>
                @endif
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        @if(Auth::guest() || $event['owner_id'] == Auth::user()->id)
                        <div class="col-12 order-sm-1 order-1">
                        @else
                        <div class="col-sm-8 col-12 order-sm-1 order-1">
                        @endif
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
                            <p class="card-text text-muted"><span id="attendeeAmount{{ $event['id'] }}">{{ count($event->allAttendees) }}</span> going</p>
                        </div>
                        @if(!Auth::guest() && $event['owner_id'] != Auth::user()->id)
                        <div class="col-sm-4 col-12 order-sm-2 order-3 center">
                            @if($event['attendees']->count() == 0)
                                @include('join-event-form')
                            @else
                                @include('leave-event-form')
                            @endif
                        </div>
                        @endif
                        <p class="card-text order-sm-3 order-2 mt-3">
                            @foreach(explode(PHP_EOL, $event['description']) as $line )
                                {{ $line }} <br>
                            @endforeach
                        </p>
                    </div>
                </div>
                @if(!$event['is_public'])
                    <p class="private">private</p>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="imageModalLabel">Image</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <img id="clickedImage" src="" alt="...">
        </div>
    </div>
</div>
@endsection
