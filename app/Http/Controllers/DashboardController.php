<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Event;
use App\Models\Invitation;
use App\Models\Attendee;
use View;

class DashboardController extends Controller
{
    public function index()
    {
        if(!Auth::check()) {
            return redirect('/login');
        }

        $privateEvents = Event::whereIn('id', Invitation::where('user_id', '=', Auth::user()->id)->select('event_id')->get())->with(['attendees' => function($q){
            $q->where('attendees.user_id', '=', Auth::user()->id);
        }])->with('allAttendees')->orderBy('date_start', 'asc')->get();

        $myEvents = Event::where('owner_id', '=', Auth::user()->id)->orderBy('date_start', 'asc')->get();

        $joinedEvents = Event::whereIn('id', (Attendee::where('user_id', '=', Auth::user()->id)->select('event_id')->get()))->with(['attendees' => function($q){
            $q->where('attendees.user_id', '=', Auth::user()->id);
        }])->with('allAttendees')->orderBy('date_start', 'asc')->get();

        return View::make('dashboard')->with([
            'privateEvents' => $privateEvents,
            'myEvents' => $myEvents,
            'joinedEvents' => $joinedEvents,
        ]);
    }
}
