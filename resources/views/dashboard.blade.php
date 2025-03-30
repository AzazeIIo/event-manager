@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        
        <div class="col">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    <div class="row">
                    <div class="col-4">
                        <h5>Events you have recently been invited to</h5>
                        @if(count($privateEvents) == 0)
                            <p>Nothing to show yet.</p>
                        @else
                        <div id="carouselPrivateEvents" class="carousel slide">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#carouselPrivateEvents" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                @for($i = 1; $i < min(count($privateEvents), 5); $i++)
                                <button type="button" data-bs-target="#carouselPrivateEvents" data-bs-slide-to="{{$i}}" aria-label="Slide {{$i}}"></button>
                                @endfor
                            </div>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <a href="/events/{{$privateEvents[0]['id']}}">
                                    @if($privateEvents[0]['image'])
                                    <img src="/storage/{{ $privateEvents[0]['image'] }}" class="d-block w-100" alt="...">
                                    @else
                                    <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="100%" height="100%" fill="#777" />
                                    </svg>
                                    @endif
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>{{ $privateEvents[0]['name'] }}</h5>
                                        <p>{{ $privateEvents[0]['date_start'] }}</p>
                                    </div>
                                    </a>
                                </div>
                                @for($i = 1; $i < min(count($privateEvents), 5); $i++)
                                <div class="carousel-item">
                                    <a href="/events/{{$privateEvents[$i]['id']}}">
                                    @if($privateEvents[$i]['image'])
                                    <img src="/storage/{{ $privateEvents[$i]['image'] }}" class="d-block w-100" alt="...">
                                    @else
                                    <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="100%" height="100%" fill="#777" />
                                    </svg>
                                    @endif
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>{{ $privateEvents[$i]['name'] }}</h5>
                                        <p>{{ $privateEvents[$i]['date_start'] }}</p>
                                    </div>
                                    </a>
                                </div>
                                @endfor
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselPrivateEvents" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselPrivateEvents" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                        @endif
                    </div>
                    <div class="col-4">
                        <h5>Your upcoming events</h5>
                        @if(count($myEvents) == 0)
                            <p>Nothing to show yet. <a href="/myevents">Create a new event.</a></p>
                        @else
                        <div id="carouselMyEvents" class="carousel slide">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#carouselMyEvents" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                @for($i = 1; $i < min(count($myEvents), 5); $i++)
                                <button type="button" data-bs-target="#carouselMyEvents" data-bs-slide-to="{{$i}}" aria-label="Slide {{$i}}"></button>
                                @endfor
                            </div>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <a href="/events/{{$myEvents[0]['id']}}">
                                    @if($myEvents[0]['image'])
                                    <img src="/storage/{{ $myEvents[0]['image'] }}" class="d-block w-100" alt="...">
                                    @else
                                    <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="100%" height="100%" fill="#777" />
                                    </svg>
                                    @endif
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>{{ $myEvents[0]['name'] }}</h5>
                                        <p>{{ $myEvents[0]['date_start'] }}</p>
                                    </div>
                                    </a>
                                </div>
                                @for($i = 1; $i < min(count($myEvents), 5); $i++)
                                <div class="carousel-item">
                                    <a href="/events/{{$myEvents[$i]['id']}}">
                                    @if($myEvents[$i]['image'])
                                    <img src="/storage/{{ $myEvents[$i]['image'] }}" class="d-block w-100" alt="...">
                                    @else
                                    <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="100%" height="100%" fill="#777" />
                                    </svg>
                                    @endif
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>{{ $myEvents[$i]['name'] }}</h5>
                                        <p>{{ $myEvents[$i]['date_start'] }}</p>
                                    </div>
                                    </a>
                                </div>
                                @endfor
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselMyEvents" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselMyEvents" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                        @endif
                    </div>
                    <div class="col-4">
                        <h5>Upcoming events you have joined</h5>
                        @if(count($joinedEvents) == 0)
                            <p>Nothing to show yet. <a href="/events">Join an event.</a></p>
                        @else
                        <div id="carouselJoinedEvents" class="carousel slide">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#carouselJoinedEvents" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                @for($i = 1; $i < min(count($joinedEvents), 5); $i++)
                                <button type="button" data-bs-target="#carouselJoinedEvents" data-bs-slide-to="{{$i}}" aria-label="Slide {{$i}}"></button>
                                @endfor
                            </div>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <a href="/events/{{$joinedEvents[0]['id']}}">
                                    @if($joinedEvents[0]['image'])
                                    <img src="/storage/{{ $joinedEvents[0]['image'] }}" class="d-block w-100" alt="...">
                                    @else
                                    <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="100%" height="100%" fill="#777" />
                                    </svg>
                                    @endif
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>{{ $joinedEvents[0]['name'] }}</h5>
                                        <p>{{ $joinedEvents[0]['date_start'] }}</p>
                                    </div>
                                    </a>
                                </div>
                                @for($i = 1; $i < min(count($joinedEvents), 5); $i++)
                                <div class="carousel-item">
                                    <a href="/events/{{$joinedEvents[$i]['id']}}">
                                    @if($joinedEvents[$i]['image'])
                                    <img src="/storage/{{ $joinedEvents[$i]['image'] }}" class="d-block w-100" alt="...">
                                    @else
                                    <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="100%" height="100%" fill="#777" />
                                    </svg>
                                    @endif
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>{{ $joinedEvents[$i]['name'] }}</h5>
                                        <p>{{ $joinedEvents[$i]['date_start'] }}</p>
                                    </div>
                                    </a>
                                </div>
                                @endfor
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselJoinedEvents" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselJoinedEvents" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
