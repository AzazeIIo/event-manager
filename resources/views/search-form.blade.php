<form class="mb-3">
    @csrf

    <div class="row mb-1">
        <label for="name-search" class="col-lg-12 col-sm-4 col-12 col-form-label text-lg-start text-sm-end text-start ps-3"><strong>{{ __('Event Name') }}</strong></label>

        <div class="col-lg-12 col-sm-6 col-12">
            <input id="name-search" type="text" class="form-control @error('name-search') is-invalid @enderror" name="name" value="{{ old('name-search') }}" autocomplete="name-search">

            <span id="invalid-name-search" class="invalid-feedback" role="alert">
                <strong></strong>
            </span>
        </div>
    </div>

    <div class="row mb-1">
        <label for="date_start-search" class="col-lg-12 col-sm-4 col-12 col-form-label text-lg-start text-sm-end text-start ps-3"><strong>{{ __('Starting After') }}</strong></label>

        <div class="col-lg-12 col-sm-6 col-12">
            <input id="date_start-search" type="datetime-local" class="form-control @error('date_start-search') is-invalid @enderror" name="date_start" autocomplete="current-date_start-search">

            <span id="invalid-date_start-search" class="invalid-feedback" role="alert">
                <strong></strong>
            </span>
        </div>
    </div>

    <div class="row mb-1">
        <label for="date_end-search" class="col-lg-12 col-sm-4 col-12 col-form-label text-lg-start text-sm-end text-start ps-3"><strong>{{ __('Ending Before') }}</strong></label>

        <div class="col-lg-12 col-sm-6 col-12">
            <input id="date_end-search" type="datetime-local" class="form-control @error('date_end-search') is-invalid @enderror" name="date_end" autocomplete="current-date_end-search">

            <span id="invalid-date_end-search" class="invalid-feedback" role="alert">
                <strong></strong>
            </span>
        </div>
    </div>

    <div class="row mb-1">
        <label for="city-search" class="col-lg-12 col-sm-4 col-12 col-form-label text-lg-start text-sm-end text-start ps-3"><strong>{{ __('City') }}</strong></label>

        <div class="col-lg-12 col-sm-6 col-12">
            <input id="city-search" type="text" class="form-control @error('city-search') is-invalid @enderror" name="city" value="{{ old('city-search') }}" autocomplete="city-search">

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
                    <input class="form-check-input type-checkbox search-checkbox" type="checkbox" name="type[]" value="{{ $type['id'] }}" id="{{ $type['id'] }}-search">
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
            <input id="description-search" type="text" class="form-control @error('description-search') is-invalid @enderror" name="description" value="{{ old('description-search') }}" autocomplete="description-search">

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