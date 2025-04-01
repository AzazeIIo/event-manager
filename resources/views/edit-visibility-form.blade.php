<div class="userResult container mb-3 mt-3">
    @foreach ($users as $user)
        <div class="row m-1 addCompetitorRow">
            <div class="col-6">
                {{ $user['username'] }}
            </div>
            <div class="col-6 text-center">
                <form method="POST" class="newCompetitorForm">
                    @csrf
                    <input type="hidden" name="_route" id="inviteRoute{{ $user['id'] }}-{{ $event['id'] }}" value="{{ url('events/' . $event['id'] . '/invitations') }}">
                    <button type="submit" id="{{ $user['id'] }}-{{ $event['id'] }}" class="btn btn-primary inviteBtn">
                        Invite
                    </button>
                </form>
            </div>
        </div>
    @endforeach
</div>
