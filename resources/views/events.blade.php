@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-9 order-lg-1 order-2">
            <div class="card">
                <div class="card-header">{{ __('Events') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (Auth::check() && $includeform)
                        <button type="button" class="btn btn-primary mb-3 center" id="newEventBtn">New event</button>
                        @include('new-event-form')
                        <div class="modal fade" id="removeModal" tabindex="-1" aria-labelledby="removeEventModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="removeEventModalLabel">Delete event</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this event?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Don't delete</button>
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="confirmDeletion">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div id="results">@include('event-page')</div>
                </div>
            </div>
        </div>
        <div id="sidebar" class="col-lg-3 order-lg-2 order-1 mb-3">
            <div class="card">
                <div class="card-header">Search</div>

                <div class="card-body">
                    <form class="mb-3">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="text-center">{{ __('Event Name') }}</label>

                            <div>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                <span id="invalid-name" class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="date_start" class="text-center">{{ __('Starting Date') }}</label>

                            <div>
                                <input id="date_start" type="datetime-local" class="form-control @error('date_start') is-invalid @enderror" name="date_start" required autocomplete="current-date_start">

                                <span id="invalid-date_start" class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="date_end" class="text-center">{{ __('Ending Date') }}</label>

                            <div>
                                <input id="date_end" type="datetime-local" class="form-control @error('date_end') is-invalid @enderror" name="date_end" autocomplete="current-date_end">

                                <span id="invalid-date_end" class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="city" class="text-center">{{ __('City') }}</label>

                            <div>
                                <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autocomplete="city" autofocus>

                                <span id="invalid-city" class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <p class="text-center">{{ __('Type') }}</p>

                            <div>
                                @foreach ($types as $type)
                                    <div class="form-check">
                                        <input class="form-check-input type-checkbox new-event-checkbox" type="checkbox" name="type[]" value="{{ $type['id'] }}" id="{{ $type['id'] }}">
                                        <label class="form-check-label" for="{{ $type['id'] }}">
                                            {{ $type['type_name'] }}
                                        </label>
                                    </div>
                                @endforeach
                                <span id="invalid-type" class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="description" class="text-center">{{ __('Description') }}</label>

                            <div>
                                <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" required autocomplete="description" autofocus>

                                <span id="invalid-description" class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>

                        <input type="hidden" name="owner_id" id="owner_id" value="{{ Auth::user()->id }}">

                        <div class="row mb-0">
                            <div class="center">
                                <button id="searchBtn" type="submit" class="btn btn-primary">
                                    Search
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
