<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Event;
use App\Models\User;
use App\Models\Attendee;
use Illuminate\Http\Request;
use App\Http\Requests\StoreInvitationRequest;
use Auth;
use View;

class InvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Event $event)
    {
        $invitedUsers = Invitation::where('event_id', '=', $event['id'])->pluck('user_id');
        $attendees = Attendee::where('event_id', '=', $event['id'])->pluck('user_id');
        $pendingUsers = User::whereIn('id', $invitedUsers)->whereNotIn('id', $attendees);
        
        return View::make('edit-visibility-form')->with([
            'users' => $pendingUsers->paginate(10, ['*'], 'userPage'),
            'event' => $event,
            'page' => 'pending'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Event $event)
    {
        $invitedUsers = Invitation::where('event_id', '=', $event['id'])->pluck('user_id');
        $uninvitedUsers = User::whereNotIn('id', $invitedUsers);
        
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
    public function destroy(Invitation $invitation)
    {
        //
    }
}
