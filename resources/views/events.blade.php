@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Events') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @foreach ($events as $event)
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-4">
                            <img src="..." class="img-fluid rounded-start" alt="...">
                            </div>
                            <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">{{ $event['name'] }}</h5>
                                <p class="card-text"><strong>{{ $event['date_start']->format("D, d M Y H:i") }} – {{ $event['date_end']->format("D, d M Y H:i") }}</strong></p>
                                <p class="card-text"><strong>{{ $event['location'] }}, {{ $event['city'] }}</strong></p>
                                <p class="card-text">{{ $event['description'] }}</p>
                            </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    {{ $events->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
