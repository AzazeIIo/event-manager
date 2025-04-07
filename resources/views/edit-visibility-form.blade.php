<div id="event-{{ $event['id'] }}">
<div class="row g-0 editVisibilityForm">
    <div class="col-lg-11">
        <div class="card-body">
            <ul class="nav nav-tabs">
                @if(!$event['is_public'])
                <li class="nav-item">
                    <button id="send-{{ $event['id'] }}" class="nav-link invitations-nav nav-send nav-{{ $event['id'] }} {{ $page == 'sending' ? 'active' : ''}}" {{ $page == 'sending' ? 'aria-current="page"' : ''}}>Send invitations</button>
                </li>
                <li class="nav-item">
                    <button id="pending-{{ $event['id'] }}" class="nav-link invitations-nav nav-pending nav-{{ $event['id'] }} {{ $page == 'pending' ? 'active' : ''}}" {{ $page == 'pending' ? 'aria-current="page"' : ''}}>Pending invitations</button>
                </li>
                @endif
                <li class="nav-item">
                    <button id="attendees-{{ $event['id'] }}" class="nav-link invitations-nav nav-attendees nav-{{ $event['id'] }} {{ $page == 'attendees' ? 'active' : ''}}" {{ $page == 'attendees' ? 'aria-current="page"' : ''}}>Attendees</button>
                </li>
                <button id="closeInvitations-{{ $event['id'] }}" class="btn btn-secondary closeInvitationsBtn ms-auto">
                    Close
                </button>
            </ul>
        
            <div class="text-center" id="errorMsgContainer"></div>

            <div class="userResult container mb-3 mt-3">
                @if(count($users) == 0)
                <p>Nothing to show right now.</p>
                @endif
                @foreach ($users as $user)
                    <div class="row m-1 userRow">
                        <div class="col-6">
                            {{ $user['username'] }}
                        </div>
                        <div class="col-6 text-center">
                            @if($page == 'sending')
                            <form method="POST" class="newInvitationForm">
                                @csrf
                                <input type="hidden" name="_route" id="inviteRoute{{ $user['id'] }}-{{ $event['id'] }}" value="{{ url('events/' . $event['id'] . '/invitations') }}">
                                <button type="submit" id="{{ $user['id'] }}-{{ $event['id'] }}" class="btn btn-primary inviteBtn">
                                    Invite
                                </button>
                            </form>
                            @elseif(!$event['is_public'])
                            <form method="POST" class="deleteInvitationForm">
                                @csrf
                                <input type="hidden" name="_route" id="uninviteRoute{{ $user['id'] }}-{{ $event['id'] }}" value="{{ route('events.invitations.destroy', [$event['id'], $user['invitations'][0]['id']]) }}">
                                <button type="submit" id="uninvite-{{ $user['id'] }}-{{ $event['id'] }}" class="btn btn-primary {{$page == 'pending' ? 'uninviteBtn' : 'uninviteAttendeeBtn'}}">
                                    Uninvite
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div id="pagination{{$event['id']}}" class="userPagination center {{ $page == 'sending' ? 'sendingPagination' : ($page == 'pending' ? 'pendingPagination' : 'attendeesPagination')}}">
                {{$users->links()}}
            </div>
        </div>
    </div>
</div>
</div>