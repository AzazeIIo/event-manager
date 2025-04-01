



<div class="row g-0 editVisibilityForm">
    <div class="col-lg-11">
        <div class="card-body">
        
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Send invitations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pending invitations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Attendees</a>
                </li>
            </ul>
        
            <div class="text-center" id="errorMsgContainer"></div>

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

            <div id="pagination{{$event['id']}}" class="userPagination center">
                {{$users->links()}}
            </div>
        </div>
    </div>
</div>