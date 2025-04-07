@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div id="sidebar" class="col-lg-3 order-lg-1 order-2">
            <div class="card">
                <div class="card-header ">Search</div>
                <a id="clearFilters" class="text-center mt-3" href="{{ Request::path() }}">Clear filters</a>
                <div id="sidebar-card" class="card-body pt-1">
                    @include('search-form')
                </div>
            </div>
        </div>
        
        <div class="col-lg-9 order-lg-2 order-1 mb-3">
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
                        <div class="modal fade" id="removeImgModal" tabindex="-1" aria-labelledby="removeImgModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="removeImgModalLabel">Delete image</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this image?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Don't delete</button>
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="confirmImgDeletion">Delete</button>
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

<div class="toast-container" style="position: fixed; bottom: 1rem; right: 1rem;">
    <div id="newEventToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">New event</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Event was successfully created.
        </div>
    </div>
    <div id="editEventToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Edit event</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Event was successfully edited.
        </div>
    </div>
    <div id="deleteEventToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Delete event</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Event was successfully deleted.
        </div>
    </div>
    <div id="deleteImageToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Delete image</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Image was successfully deleted.
        </div>
    </div>
</div>
@endsection
@pushIf(Route::current()->getName() == 'myevents', 'scripts')
    <script type="module" src="/js/myevents.js"></script>
@endPushIf
