@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div id="sidebar" class="col-lg-3 order-lg-1 order-2">
            <div class="card">
                <div class="card-header ">Search</div>

                <div id="sidebar-card" class="card-body pt-1">
                    <form class="mb-3">
                        @csrf

                        <div class="row mb-1">
                            <label for="name-search" class="col-lg-12 col-sm-4 col-12 col-form-label text-lg-start text-sm-end text-start ps-3"><strong>{{ __('Event Name') }}</strong></label>

                            <div class="col-lg-12 col-sm-6 col-12">
                                <input id="name-search" type="text" class="form-control @error('name-search') is-invalid @enderror" name="name" value="{{ old('name-search') }}" required autocomplete="name-search" autofocus>

                                <span id="invalid-name-search" class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row mb-1">
                            <label for="date_start-search" class="col-lg-12 col-sm-4 col-12 col-form-label text-lg-start text-sm-end text-start ps-3"><strong>{{ __('Starting Date') }}</strong></label>

                            <div class="col-lg-12 col-sm-6 col-12">
                                <input id="date_start-search" type="datetime-local" class="form-control @error('date_start-search') is-invalid @enderror" name="date_start" required autocomplete="current-date_start-search">

                                <span id="invalid-date_start-search" class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row mb-1">
                            <label for="date_end-search" class="col-lg-12 col-sm-4 col-12 col-form-label text-lg-start text-sm-end text-start ps-3"><strong>{{ __('Ending Date') }}</strong></label>

                            <div class="col-lg-12 col-sm-6 col-12">
                                <input id="date_end-search" type="datetime-local" class="form-control @error('date_end-search') is-invalid @enderror" name="date_end" autocomplete="current-date_end-search">

                                <span id="invalid-date_end-search" class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row mb-1">
                            <label for="city-search" class="col-lg-12 col-sm-4 col-12 col-form-label text-lg-start text-sm-end text-start ps-3"><strong>{{ __('City-search') }}</strong></label>

                            <div class="col-lg-12 col-sm-6 col-12">
                                <input id="city-search" type="text" class="form-control @error('city-search') is-invalid @enderror" name="city" value="{{ old('city-search') }}" required autocomplete="city-search" autofocus>

                                <span id="invalid-city-search" class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row mb-1">
                            <p class="col-lg-12 col-sm-4 col-12 col-form-label text-lg-start text-sm-end text-start ps-3"><strong>{{ __('Type') }}</strong></p>

                            <div class="col-lg-12 col-sm-6 col-12">
                                @foreach ($types as $type)
                                    <div class="form-check">
                                        <input class="form-check-input type-checkbox new-event-checkbox" type="checkbox" name="type[]" value="{{ $type['id'] }}" id="{{ $type['id'] }}-search">
                                        <label class="form-check-label" for="{{ $type['id'] }}-search">
                                            {{ $type['type_name'] }}
                                        </label>
                                    </div>
                                @endforeach
                                <span id="invalid-type-search" class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row mb-1">
                            <label for="description-search" class="col-lg-12 col-sm-4 col-12 col-form-label text-lg-start text-sm-end text-start ps-3"><strong>{{ __('Description') }}</strong></label>

                            <div class="col-lg-12 col-sm-6 col-12">
                                <input id="description-search" type="text" class="form-control @error('description-search') is-invalid @enderror" name="description" value="{{ old('description-search') }}" required autocomplete="description-search" autofocus>

                                <span id="invalid-description-search" class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>

                        <input type="hidden" name="owner_id" id="owner_id" value="{{ Auth::user()->id }}">

                        <div class="row mb-0">
                            <div class="center">
                                <button id="searchBtn" type="submit" class="btn btn-primary mt-2">
                                    Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8 order-lg-2 order-1 mb-3">
            <div class="card">
                <div class="card-header">{{ __('Events') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (Auth::check() && $includeform)
                        <div class="accordion" id="newEvent">
                            <div class="accordion-item mb-3">
                                <div class="accordion-header" id="newEventBtn">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-form" aria-expanded="false" aria-controls="collapse-form">
                                        <h5 class="mb-0">Create new event</h5>
                                    </button>
                                </div>
                                <div id="collapse-form" class="accordion-collapse collapse" aria-labelledby="newEventBtn" data-bs-parent="#newEvent">
                                    <div class="accordion-body">
                                        @include('new-event-form')
                                    </div>
                                </div>
                            </div>
                        </div>
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
        
    </div>
</div>
@endsection
