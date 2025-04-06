<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAttendeeRequest;
use App\Http\Requests\DestroyAttendeeRequest;
use Auth;
use View;

class AttendeeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttendeeRequest $request, Event $event)
    {
        $attendee = Attendee::create([
            'user_id' => Auth::user()->id,
            'event_id' => $event['id']
        ]);
        return View::make('leave-event-form')->with([
            'event' => Event::where('id', '=', $event['id'])->with(['attendees' => function($q){
                    $q->where('attendees.user_id', '=', Auth::user()->id);
                }])->with('allAttendees')->get()[0],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyAttendeeRequest $request, Event $event, Attendee $attendee)
    {
        $attendee->delete($attendee);
        return View::make('join-event-form')->with([
            'event' => Event::where('id', '=', $event['id'])->with(['attendees' => function($q){
                    $q->where('attendees.user_id', '=', Auth::user()->id);
                }])->with('allAttendees')->get()[0],
        ]);
    }
}
