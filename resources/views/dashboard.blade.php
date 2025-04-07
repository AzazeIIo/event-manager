@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        
        <div class="col">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-lg-6">
                            <h5 class="text-center mt-3 mb-3"><strong>Upcoming events you have joined</strong></h5>
                            @if(count($joinedEvents) == 0)
                                <p class="text-center">Nothing to show yet. <a href="/events">Join an event.</a></p>
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
                        <div class="col-lg-6">
                            <h5 class="text-center mt-3 mb-3"><strong>Your upcoming events</strong></h5>
                            @if(count($yourEvents) == 0)
                                <p class="text-center">Nothing to show yet. <a href="/myevents">Create a new event.</a></p>
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
                    </div>
                    <div class="row mb-3">
                        <?php $json = json_encode([
                            'yourTypes' => $yourTypes,
                            'joinedTypes' => $joinedTypes,
                            'days' => $days,
                            'count' => $count
                        ]); ?>
                        <script>let data = <?php echo $json; ?></script>
                        <div class="row mt-3">
                            <div class="col-lg-3 col-md-6 col-12 d-none d-lg-block">
                                <h5 class="text-center mb-3 mt-3"><strong>Types of events you join</strong></h5>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12 d-none d-lg-block">
                                <h5 class="text-center mb-3 mt-3"><strong>Your events in the next 30 days</strong></h5>
                            </div>
                            <div class="col-lg-3 col-md-6 col-12 d-none d-lg-block">
                                <h5 class="text-center mb-3 mt-3"><strong>Types of your events</strong></h5>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12 charts p-0 order-2 order-lg-1">
                            <h5 class="text-center mb-3 mt-3 d-block d-lg-none"><strong>Frequency of types of events you join</strong></h5>
                            <div class="chart-container" style="margin:auto;position: relative; height:16rem; width:90%">
                                <canvas id="canvasJoinedTags"></canvas>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-12 charts p-0 order-1 order-lg-2">
                            <h5 class="text-center mb-3 mt-3 d-block d-lg-none"><strong>Your events in the next 30 days</strong></h5>
                            <div class="chart-container" style="margin:auto;position: relative; height:16rem; width:90%">
                                <canvas id="canvasYour30"></canvas>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12 charts p-0 order-3">
                            <h5 class="text-center mb-3 mt-3 d-block d-lg-none"><strong>Frequency of tags you use</strong></h5>
                            <div class="chart-container" style="margin:auto;position: relative; height:16rem; width:90%">
                                <canvas id="canvasYourTags"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="js/dashboard.js"></script>
@endpush
