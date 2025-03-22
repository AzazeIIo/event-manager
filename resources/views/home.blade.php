@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('My events') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" class="mb-3">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Event Name *') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="dateStart" class="col-md-4 col-form-label text-md-end">{{ __('Starting Date *') }}</label>

                            <div class="col-md-6">
                                <input id="dateStart" type="datetime-local" class="form-control @error('dateStart') is-invalid @enderror" name="dateStart" required autocomplete="current-dateStart">

                                @error('dateStart')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="dateEnd" class="col-md-4 col-form-label text-md-end">{{ __('Ending Date') }}</label>

                            <div class="col-md-6">
                                <input id="dateEnd" type="datetime-local" class="form-control @error('dateEnd') is-invalid @enderror" name="dateEnd" autocomplete="current-dateEnd">

                                @error('dateEnd')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="city" class="col-md-4 col-form-label text-md-end">{{ __('City *') }}</label>

                            <div class="col-md-6">
                                <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autocomplete="city" autofocus>

                                @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="location" class="col-md-4 col-form-label text-md-end">{{ __('Location *') }}</label>

                            <div class="col-md-6">
                                <input id="location" type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="{{ old('location') }}" required autocomplete="location" autofocus>

                                @error('location')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="type" class="col-md-4 col-form-label text-md-end">{{ __('Type') }}</label>

                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="1">
                                    <label class="form-check-label" for="1">
                                        Art and culture
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="2">
                                    <label class="form-check-label" for="2">
                                        Charity
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="3">
                                    <label class="form-check-label" for="3">
                                        Conference
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="4">
                                    <label class="form-check-label" for="4">
                                        Educational
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="5">
                                    <label class="form-check-label" for="5">
                                        Festival
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="6">
                                    <label class="form-check-label" for="6">
                                        Social
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="7">
                                    <label class="form-check-label" for="7">
                                        Sport
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="8">
                                    <label class="form-check-label" for="8">
                                        Virtual
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="9">
                                    <label class="form-check-label" for="9">
                                        Workshop
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <textarea rows="5" id="description" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" autocomplete="description" autofocus></textarea>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('Image') }}</label>

                            <div class="col-md-6">
                                <input class="form-control" type="file" id="image">

                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="is-public" class="col-md-4 col-form-label text-md-end">{{ __('Visibility') }}</label>

                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is-public" id="public" required checked>

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
                                    <input class="form-check-input" type="radio" name="is-public" id="private" required>

                                    <label class="form-check-label" for="private">
                                        {{ __('Private') }}<br>
                                        <small class="text-muted">You choose who can see your event.</small>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Create') }}
                                </button>
                            </div>
                        </div>
                    </form>
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
