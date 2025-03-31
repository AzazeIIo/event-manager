@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        
        <div class="col">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    <div class="row mb-3">
                        <!-- <div class="col-md-4">
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
                        </div> -->
                        <div class="col-lg-6">
                            <h5 class="text-center"><strong>Your upcoming events</strong></h5>
                            @if(count($yourEvents) == 0)
                                <p>Nothing to show yet. <a href="/myevents">Create a new event.</a></p>
                            @else
                            <div id="carouselMyEvents" class="carousel slide">
                                <div class="carousel-indicators">
                                    <button type="button" data-bs-target="#carouselMyEvents" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                    @for($i = 1; $i < min(count($yourEvents), 5); $i++)
                                    <button type="button" data-bs-target="#carouselMyEvents" data-bs-slide-to="{{$i}}" aria-label="Slide {{$i}}"></button>
                                    @endfor
                                </div>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <a href="/events/{{$yourEvents[0]['id']}}">
                                        @if($yourEvents[0]['image'])
                                        <img src="/storage/{{ $yourEvents[0]['image'] }}" class="d-block w-100" alt="...">
                                        @else
                                        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="100%" height="100%" fill="#777" />
                                        </svg>
                                        @endif
                                        <div class="carousel-caption">
                                            <h5>{{ $yourEvents[0]['name'] }}</h5>
                                            <p><span class="d-none d-md-inline">Starting date: </span>{{ $yourEvents[0]['date_start'] }}</p>
                                            @if($yourEvents[0]['date_end'])
                                            <p><span class="d-none d-md-inline">Ending date: </span>{{ $yourEvents[0]['date_end'] }}</p>
                                            @endif
                                            <p>{{ $yourEvents[0]['location'] }}, {{ $yourEvents[0]['city'] }}</p>
                                        </div>
                                        </a>
                                    </div>
                                    @for($i = 1; $i < min(count($yourEvents), 5); $i++)
                                    <div class="carousel-item">
                                        <a href="/events/{{$yourEvents[$i]['id']}}">
                                        @if($yourEvents[$i]['image'])
                                        <img src="/storage/{{ $yourEvents[$i]['image'] }}" class="d-block w-100" alt="...">
                                        @else
                                        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="100%" height="100%" fill="#777" />
                                        </svg>
                                        @endif
                                        <div class="carousel-caption">
                                            <h5>{{ $yourEvents[$i]['name'] }}</h5>
                                            <p><span class="d-none d-md-inline">Starting date: </span>{{ $yourEvents[$i]['date_start'] }}</p>
                                            @if($yourEvents[$i]['date_end'])
                                            <p><span class="d-none d-md-inline">Ending date: </span>{{ $yourEvents[$i]['date_end'] }}</p>
                                            @endif
                                            <p>{{ $yourEvents[$i]['location'] }}, {{ $yourEvents[$i]['city'] }}</p>
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
                        <div class="col-lg-6">
                            <h5 class="text-center"><strong>Upcoming events you have joined</strong></h5>
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
                                        <div class="carousel-caption">
                                            <h5>{{ $joinedEvents[0]['name'] }}</h5>
                                            <p><span class="d-none d-md-inline">Starting date: </span>{{ $joinedEvents[0]['date_start'] }}</p>
                                            @if($joinedEvents[0]['date_end'])
                                            <p><span class="d-none d-md-inline">Ending date: </span>{{ $joinedEvents[0]['date_end'] }}</p>
                                            @endif
                                            <p>{{ $joinedEvents[0]['location'] }}, {{ $joinedEvents[0]['city'] }}</p>
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
                                        <div class="carousel-caption">
                                            <h5>{{ $joinedEvents[$i]['name'] }}</h5>
                                            <p><span class="d-none d-md-inline">Starting date: </span>{{ $joinedEvents[$i]['date_start'] }}</p>
                                            @if($joinedEvents[$i]['date_end'])
                                            <p><span class="d-none d-md-inline">Ending date: </span>{{ $joinedEvents[$i]['date_end'] }}</p>
                                            @endif
                                            <p>{{ $joinedEvents[$i]['location'] }}, {{ $joinedEvents[$i]['city'] }}</p>
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
                    <div class="row mb-3">
                        <?php $json = json_encode([
                            'yourTypes' => $yourTypes,
                            'joinedTypes' => $joinedTypes,
                            'days' => $days,
                            'count' => $count
                        ]); ?>
                        <script>let data = <?php echo $json; ?></script>
                        <div class="col-lg-3 col-md-6 col-12 charts mb-md-5">
                            <h5 class="text-center"><strong>Frequency of tags you use</strong></h5>
                            <canvas id="canvasYourTags" style="height:100%;width:100%;max-width:700px"></canvas>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12 charts mb-md-5">
                            <h5 class="text-center"><strong>Your events in the next 30 days</strong></h5>
                            <canvas id="canvasYour30" style="height:100%;width:100%;max-width:700px"></canvas>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12 charts mb-md-5">
                            <h5 class="text-center"><strong>Frequency of types of events you join</strong></h5>
                            <canvas id="canvasJoinedTags" style="height:100%;width:100%;max-width:700px"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
