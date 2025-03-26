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
    </div>
</div>
@endsection
