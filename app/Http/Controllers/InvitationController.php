<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Event;
use App\Models\User;
use App\Models\Attendee;
use Illuminate\Http\Request;
use App\Http\Requests\StoreInvitationRequest;
use App\Http\Requests\DestroyInvitationRequest;
use App\Http\Controllers\AttendeeController;
use Auth;
use View;

class InvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Event $event)
    {
        $invitedUsers = Invitation::where('event_id', '=', $event['id'])->pluck('user_id');
        $eventAttendees = Attendee::where('event_id', '=', $event['id'])->pluck('user_id');
        $users;
        $page;

        if($request->attendees) {
            $users = User::whereIn('id', $eventAttendees)->with(['invitations' => function($q) use ($event) {
                $q->where('invitations.event_id', '=', $event['id']);
            }]);
            $page = 'attendees';
        } else {
            $users = User::whereIn('id', $invitedUsers)->whereNotIn('id', $eventAttendees)->with(['invitations' => function($q) use ($event) {
                $q->where('invitations.event_id', '=', $event['id']);
            }]);
            $page = 'pending';
        }
        
        return View::make('edit-visibility-form')->with([
            'users' => $users->paginate(10, ['*'], 'userPage'),
            'event' => $event,
            'page' => $page
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Event $event)
    {
        $invitedUsers = Invitation::where('event_id', '=', $event['id'])->pluck('user_id');
        $uninvitedUsers = User::whereNotIn('id', $invitedUsers)->whereNot('id', '=', Auth::user()->id);
        
        return View::make('edit-visibility-form')->with([
            'users' => $uninvitedUsers->paginate(10, ['*'], 'userPage'),
            'event' => $event,
            'page' => 'sending'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvitationRequest $request, Event $event)
    {
        $fields = $request->validated();
        $invitation = Invitation::create([
            'user_id' => $fields['user_id'],
            'event_id' => $event['id']
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Invitation $invitation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invitation $invitation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invitation $invitation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyInvitationRequest $request, Event $event, Invitation $invitation)
    {
        $fields = $request->validated();
        $invitation->delete($invitation);

        $userPage = $fields['userPage'];
        $showResult;
        if ($fields['is_attendee']) {
            $showResult = new Request([
                'attendees' => 1,
                'userPage' => $userPage
            ]);
        } else {
            $showResult = new Request([
                'attendees' => 0,
                'userPage' => $userPage
            ]);
        }
        return $this->index($showResult, $event);
    }
}
