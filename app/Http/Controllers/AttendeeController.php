<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAttendeeRequest;
use App\Http\Requests\DestroyAttendeeRequest;
use Auth;
use View;

class AttendeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttendeeRequest $request, Event $event)
    {
        $fields = $request->validated();
        $fields['user_id'] = strip_tags($fields['user_id']);
        $fields['event_id'] = strip_tags($fields['event_id']);
        $attendee = Attendee::create($fields);
        return View::make('leave-event-form')->with([
            'event' => Event::where('id', '=', $event['id'])->with(['attendees' => function($q){
                    $q->where('attendees.user_id', '=', Auth::user()->id);
                }])->with('allAttendees')->get()[0],
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendee $attendee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendee $attendee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendee $attendee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyAttendeeRequest $request, Event $event)
    {
        $request->validated();
        $attendee = Attendee::find($request['attendee_id']);
        $attendee->delete($attendee);
        // return count($event->attendees);
        return View::make('join-event-form')->with([
            'event' => Event::where('id', '=', $event['id'])->with(['attendees' => function($q){
                    $q->where('attendees.user_id', '=', Auth::user()->id);
                }])->with('allAttendees')->get()[0],
        ]);
    }
}
