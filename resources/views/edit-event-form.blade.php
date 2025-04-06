<div id="{{ $event['id'] }}">
<div class="row g-0 editEventForm">
    <div class="col-lg-11">
        <div class="card-body">
            <form method="POST" class="mb-3" action="{{ url('events') }}" enctype="multipart/form-data">
                @csrf

                <div class="row mb-3">
                    <label for="name{{ $event['id'] }}" class="col-sm-4 col-form-label text-sm-end"><strong>{{ __('Event Name *') }}</strong></label>

                    <div class="col-sm-6">
                        <input id="name{{ $event['id'] }}" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $event['name'] }}" required autocomplete="name" autofocus>

                        <span id="invalid-name{{ $event['id'] }}" class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="date_start{{ $event['id'] }}" class="col-sm-4 col-form-label text-sm-end"><strong>{{ __('Starting Date *') }}</strong></label>

                    <div class="col-sm-6">
                        <input id="date_start{{ $event['id'] }}" type="datetime-local" class="form-control @error('date_start') is-invalid @enderror" name="date_start" value="{{ $event['date_start'] }}" required autocomplete="current-date_start">

                        <span id="invalid-date_start{{ $event['id'] }}" class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="date_end{{ $event['id'] }}" class="col-sm-4 col-form-label text-sm-end"><strong>{{ __('Ending Date') }}</strong></label>

                    <div class="col-sm-6">
                        <input id="date_end{{ $event['id'] }}" type="datetime-local" class="form-control @error('date_end') is-invalid @enderror" name="date_end" value="{{ $event['date_end'] }}" autocomplete="current-date_end">

                        <span id="invalid-date_end{{ $event['id'] }}" class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="city{{ $event['id'] }}" class="col-sm-4 col-form-label text-sm-end"><strong>{{ __('City *') }}</strong></label>

                    <div class="col-sm-6">
                        <input id="city{{ $event['id'] }}" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ $event['city'] }}" required autocomplete="city" autofocus>

                        <span id="invalid-city{{ $event['id'] }}" class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="location{{ $event['id'] }}" class="col-sm-4 col-form-label text-sm-end"><strong>{{ __('Location *') }}</strong></label>

                    <div class="col-sm-6">
                        <input id="location{{ $event['id'] }}" type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="{{ $event['location'] }}" required autocomplete="location" autofocus>

                        <span id="invalid-location{{ $event['id'] }}" class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                </div>

                <div class="row mb-3">
                    <p class="col-sm-4 col-form-label text-sm-end"><strong>{{ __('Type') }}</strong><br><small class="text-muted">Select up to 3</small></p>

                    <div class="col-sm-6">
                        @foreach ($types as $type)
                            <div class="form-check">
                                <input class="form-check-input type-checkbox edit-event-checkbox{{ $event['id'] }}" type="checkbox" name="type[]" value="{{ $type['id'] }}" {{ in_array($type['id'], $event->typeids()) ? "checked" : "" }} id="{{ $type['id'] }}-{{ $event['id'] }}">
                                <label class="form-check-label" for="{{ $type['id'] }}-{{ $event['id'] }}">
                                    {{ $type['type_name'] }}
                                </label>
                            </div>
                        @endforeach
                        <span id="invalid-type{{ $event['id'] }}" class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="description{{ $event['id'] }}" class="col-sm-4 col-form-label text-sm-end"><strong>{{ __('Description') }}</strong><br><small class="text-muted">Write up to 5000 characters</small></label>

                    <div class="col-sm-6">
                        <textarea rows="5" id="description{{ $event['id'] }}" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ $event['description'] }}" autocomplete="description" autofocus>{{ $event['description'] }}</textarea>

                        <span id="invalid-description{{ $event['id'] }}" class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                </div>

                @if ($event['image'])
                <div id="img{{ $event['id'] }}" class="row mb-3">
                    <label for="image" class="col-sm-4 col-form-label text-sm-end"><strong>{{ __('Image') }}</strong></label>

                    <div class="col-sm-6">
                        <img src="/storage/{{ $event['image'] }}" alt="..." class="image-small">
                        <button id="deleteImg{{ $event['id'] }}" data-bs-toggle="modal" data-bs-target="#removeImgModal" class="btn btn-danger deleteImgBtn">Delete this image</button>
                    </div>
                </div>
                @else
                <div id="imgform{{ $event['id'] }}" class="row mb-3">
                    <label for="image" class="col-sm-4 col-form-label text-sm-end"><strong>{{ __('Image') }}</strong></label>

                    <div class="col-sm-6">
                        <input class="form-control" type="file" id="image{{ $event['id'] }}" name="image">

                        <span id="invalid-image{{ $event['id'] }}" class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                </div>
                @endif

                <div class="row mb-3">
                    <p class="col-sm-4 col-form-label text-sm-end"><strong>{{ __('Visibility') }}</strong></p>

                    <div class="col-sm-6">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_public{{ $event['id'] }}" id="public{{ $event['id'] }}" value="1" required {{ $event['is_public'] ? "checked" : "" }}>

                            <label class="form-check-label" for="public{{ $event['id'] }}">
                                {{ __('Public') }}<br>
                                <small class="text-muted">Everyone can see and join your event.</small>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-6 offset-sm-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="is_public{{ $event['id'] }}" id="private{{ $event['id'] }}" value="0" required {{ $event['is_public'] ? "" : "checked" }}>

                            <label class="form-check-label" for="private{{ $event['id'] }}">
                                {{ __('Private') }}<br>
                                <small class="text-muted">You choose who can see your event.</small>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-8 offset-sm-4">
                        <button id="reset{{ $event['id'] }}" type="reset" class="btn btn-secondary me-4 resetEditEventBtn">
                            {{ __('Reset') }}
                        </button>
                        <form class="center">
                            @csrf
                            <input type="hidden" name="_route" id="editroute{{ $event['id'] }}" value="{{ route('events.update', [$event['id']]) }}">
                            <button type="submit" id="confirm{{ $event['id'] }}" class="btn btn-primary confirmEditEventBtn">
                            {{ __('Confirm changes') }}
                            </button>
                        </form>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
