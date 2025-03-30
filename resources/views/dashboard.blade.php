@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        
        <div class="col">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <div class="row">
                        <h5>Events you have recently been invited to</h5>
                            {{ $privateEvents }}
                        <h5>Your upcoming events</h5>
                            {{ $myEvents }}
                        <h5>Upcoming events you have joined</h5>
                            {{ $joinedEvents }}
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
