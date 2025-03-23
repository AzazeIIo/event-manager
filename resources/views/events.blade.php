@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">{{ __('Events') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (Auth::check() && $includeform)
                        @include('neweventform')
                    @endif
                    @foreach ($events as $event)
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-3 center">
                                <img src="{{ 'storage/' . $event['image'] }}" class="userimage img-fluid rounded" alt="...">
                            </div>
                            <div class="col-md-7">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $event['name'] }}</h5>
                                    <p class="card-text"><strong>{{ $event['date_start']->format("D, d M Y H:i") }} – {{ $event['date_end']->format("D, d M Y H:i") }}</strong></p>
                                    <p class="card-text"><strong>{{ $event['location'] }}, {{ $event['city'] }}</strong></p>
                                    <p class="card-text text-muted">{{ count($event->attendees) }} going</p>
                                    <p class="card-text">{{ $event->short_description }}</p>
                                    <a href="#">See more</a>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3 center">
                                <button type="submit" class="btn btn-primary">
                                    I'll be there
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="center">{{ $events->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
