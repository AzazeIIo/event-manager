<form method="POST" class="mb-3 editEventForm" action="{{ url('events') }}" enctype="multipart/form-data">
    @csrf

    <div class="row mb-3">
        <label for="name{{ $event['id'] }}" class="col-md-4 col-form-label text-md-end">{{ __('Event Name *') }}</label>

        <div class="col-md-6">
            <input id="name{{ $event['id'] }}" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $event['name'] }}" required autocomplete="name" autofocus>

            <span id="invalid-name{{ $event['id'] }}" class="invalid-feedback" role="alert">
                <strong></strong>
            </span>
        </div>
    </div>

    <div class="row mb-3">
        <label for="date_start{{ $event['id'] }}" class="col-md-4 col-form-label text-md-end">{{ __('Starting Date *') }}</label>

        <div class="col-md-6">
            <input id="date_start{{ $event['id'] }}" type="datetime-local" class="form-control @error('date_start') is-invalid @enderror" name="date_start" value="{{ $event['date_start'] }}" required autocomplete="current-date_start">

            <span id="invalid-date_start{{ $event['id'] }}" class="invalid-feedback" role="alert">
                <strong></strong>
            </span>
        </div>
    </div>

    <div class="row mb-3">
        <label for="date_end{{ $event['id'] }}" class="col-md-4 col-form-label text-md-end">{{ __('Ending Date') }}</label>

        <div class="col-md-6">
            <input id="date_end{{ $event['id'] }}" type="datetime-local" class="form-control @error('date_end') is-invalid @enderror" name="date_end" value="{{ $event['date_end'] }}" autocomplete="current-date_end">

            <span id="invalid-date_end{{ $event['id'] }}" class="invalid-feedback" role="alert">
                <strong></strong>
            </span>
        </div>
    </div>

    <div class="row mb-3">
        <label for="city{{ $event['id'] }}" class="col-md-4 col-form-label text-md-end">{{ __('City *') }}</label>

        <div class="col-md-6">
            <input id="city{{ $event['id'] }}" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ $event['city'] }}" required autocomplete="city" autofocus>

            <span id="invalid-city{{ $event['id'] }}" class="invalid-feedback" role="alert">
                <strong></strong>
            </span>
        </div>
    </div>

    <div class="row mb-3">
        <label for="location{{ $event['id'] }}" class="col-md-4 col-form-label text-md-end">{{ __('Location *') }}</label>

        <div class="col-md-6">
            <input id="location{{ $event['id'] }}" type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="{{ $event['location'] }}" required autocomplete="location" autofocus>

            <span id="invalid-location{{ $event['id'] }}" class="invalid-feedback" role="alert">
                <strong></strong>
            </span>
        </div>
    </div>

    <div class="row mb-3">
        <p class="col-md-4 col-form-label text-md-end">{{ __('Type') }}<br><small class="text-muted">Select up to 3</small></p>

        <div class="col-md-6">
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
        <label for="description{{ $event['id'] }}" class="col-md-4 col-form-label text-md-end">{{ __('Description') }}<br><small class="text-muted">Write up to 5000 characters</small></label>

        <div class="col-md-6">
            <textarea rows="5" id="description{{ $event['id'] }}" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ $event['description'] }}" autocomplete="description" autofocus>{{ $event['description'] }}</textarea>

            <span id="invalid-description{{ $event['id'] }}" class="invalid-feedback" role="alert">
                <strong></strong>
            </span>
        </div>
    </div>

    @if ($event['image'])
    <div class="row mb-3">
        <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('Image') }}</label>

        <div class="col-md-6">
            <img src="/storage/{{ $event['image'] }}" alt="..." class="image-small">
            <button class="btn btn-danger">Delete this image</button>
        </div>
    </div>
    @else
    <div class="row mb-3">
        <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('Image') }}</label>

        <div class="col-md-6">
            <input class="form-control" type="file" id="image{{ $event['id'] }}" name="image">

            <span id="invalid-image{{ $event['id'] }}" class="invalid-feedback" role="alert">
                <strong></strong>
            </span>
        </div>
    </div>
    @endif

    <div class="row mb-3">
        <p class="col-md-4 col-form-label text-md-end">{{ __('Visibility') }}</p>

        <div class="col-md-6">
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
        <div class="col-md-6 offset-md-4">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="is_public{{ $event['id'] }}" id="private{{ $event['id'] }}" value="0" required {{ $event['is_public'] ? "" : "checked" }}>

                <label class="form-check-label" for="private{{ $event['id'] }}">
                    {{ __('Private') }}<br>
                    <small class="text-muted">You choose who can see your event.</small>
                </label>
            </div>
        </div>
    </div>

    <input type="hidden" name="owner_id" id="owner_id" value="{{ Auth::user()->id }}">

    <div class="row mb-0">
        <div class="col-md-8 offset-md-4">
            <button type="reset" class="btn btn-secondary me-3 resetEditEventBtn">
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
