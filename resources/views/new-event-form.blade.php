<form class="mb-3" id="newEventForm">
    @csrf

    <div class="row mb-3">
        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Event Name *') }}</label>

        <div class="col-md-6">
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

            <span id="invalid-name" class="invalid-feedback" role="alert">
                <strong></strong>
            </span>
        </div>
    </div>

    <div class="row mb-3">
        <label for="date_start" class="col-md-4 col-form-label text-md-end">{{ __('Starting Date *') }}</label>

        <div class="col-md-6">
            <input id="date_start" type="datetime-local" class="form-control @error('date_start') is-invalid @enderror" name="date_start" required autocomplete="current-date_start">

            <span id="invalid-date_start" class="invalid-feedback" role="alert">
                <strong></strong>
            </span>
        </div>
    </div>

    <div class="row mb-3">
        <label for="date_end" class="col-md-4 col-form-label text-md-end">{{ __('Ending Date') }}</label>

        <div class="col-md-6">
            <input id="date_end" type="datetime-local" class="form-control @error('date_end') is-invalid @enderror" name="date_end" autocomplete="current-date_end">

            <span id="invalid-date_end" class="invalid-feedback" role="alert">
                <strong></strong>
            </span>
        </div>
    </div>

    <div class="row mb-3">
        <label for="city" class="col-md-4 col-form-label text-md-end">{{ __('City *') }}</label>

        <div class="col-md-6">
            <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autocomplete="city" autofocus>

            <span id="invalid-city" class="invalid-feedback" role="alert">
                <strong></strong>
            </span>
        </div>
    </div>

    <div class="row mb-3">
        <label for="location" class="col-md-4 col-form-label text-md-end">{{ __('Location *') }}</label>

        <div class="col-md-6">
            <input id="location" type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="{{ old('location') }}" required autocomplete="location" autofocus>

            <span id="invalid-location" class="invalid-feedback" role="alert">
                <strong></strong>
            </span>
        </div>
    </div>

    <div class="row mb-3">
        <p class="col-md-4 col-form-label text-md-end">{{ __('Type') }}<br><small class="text-muted">Select up to 3</small></p>

        <div class="col-md-6">
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
        <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Description') }}<br><small class="text-muted">Write up to 5000 characters</small></label>

        <div class="col-md-6">
            <textarea rows="5" id="description" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" autocomplete="description" autofocus></textarea>

            <span id="invalid-description" class="invalid-feedback" role="alert">
                <strong></strong>
            </span>
        </div>
    </div>

    <div class="row mb-3">
        <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('Image') }}</label>

        <div class="col-md-6">
            <input class="form-control" type="file" id="image" name="image">

            <span id="invalid-image" class="invalid-feedback" role="alert">
                <strong></strong>
            </span>
        </div>
    </div>

    <div class="row mb-3">
        <p class="col-md-4 col-form-label text-md-end">{{ __('Visibility') }}</p>

        <div class="col-md-6">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="is_public" id="public" value="1" required checked>

                <label class="form-check-label" for="public">
                    {{ __('Public') }}<br>
                    <small class="text-muted">Everyone can see and join your event.</small>
                </label>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6 offset-md-4">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="is_public" id="private" value="0" required>

                <label class="form-check-label" for="private">
                    {{ __('Private') }}<br>
                    <small class="text-muted">You choose who can see your event.</small>
                </label>
            </div>
        </div>
    </div>

    <input type="hidden" name="owner_id" id="owner_id" value="{{ Auth::user()->id }}">

    <div class="row mb-0">
        <div class="col-md-8 offset-md-4">
            <button id="createEventBtn" type="submit" class="btn btn-primary">
                {{ __('Create') }}
            </button>
        </div>
    </div>
</form>
