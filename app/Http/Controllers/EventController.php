<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use App\Models\Event;
use App\Models\Invitation;
use App\Models\Attendee;
use App\Models\Type;
use App\Models\User;
use App\Models\EventType;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\ShowEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Requests\DestroyEventRequest;
use Illuminate\Support\Facades\Storage;
use View;
use Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $events;
        $types = Type::all();
        $includeform = false;

        if(!Auth::check() && Route::current()->uri != 'events') {
            return redirect('/login');
        }

        date_default_timezone_set('Europe/Budapest');
        $date = new \DateTimeImmutable();

        $activeEvents = Event::where('date_start', '>=', $date->format('Y-m-d'))->orWhere('date_end', '>=', $date->format('Y-m-d'))->pluck('id');
        
        switch (Route::current()->uri) {
            case 'privateevents':
                $events = Event::whereIn('id', Invitation::where('user_id', '=', Auth::user()->id)->pluck('event_id'))
                    ->whereIn('id', $activeEvents)
                    ->with(['attendees' => function($q){
                        $q->where('attendees.user_id', '=', Auth::user()->id);
                    }])->with('allAttendees')->orderBy('date_start', 'asc');
                break;
            case 'myevents':
                $events = Event::where('owner_id', '=', Auth::user()->id)->whereIn('id', $activeEvents)->orderBy('date_start', 'asc');
                $includeform = true;
                break;
            case 'joinedevents':
                $events = Event::whereIn('id', (Attendee::where('user_id', '=', Auth::user()->id)->pluck('event_id')))->whereIn('id', $activeEvents)->with(['attendees' => function($q){
                    $q->where('attendees.user_id', '=', Auth::user()->id);
                }])->with('allAttendees')->orderBy('date_start', 'asc');
                break;
            default:
                if(Auth::guest()) {
                    $events = Event::where('is_public', '=', true)->whereIn('id', $activeEvents)->with('allAttendees')->orderBy('date_start', 'asc');
                } else {
                    $events = Event::where('is_public', '=', true)->whereIn('id', $activeEvents)->with(['attendees' => function($q){
                        $q->where('attendees.user_id', '=', Auth::user()->id);
                    }])->with('allAttendees')->orderBy('date_start', 'asc');
                }
        }

        if(count($request->all()) != 0) {
            if($request['name']) {
                $events = $events->where('name', 'LIKE', '%' . $request['name'] . '%');
            }
            if($request['date_start']) {
                $events = $events->where('date_start', '>=', $request['date_start']);
            }
            if($request['date_end']) {
                $events = $events->where('date_end', '<=', $request['date_end']);
            }
            if($request['city']) {
                $events = $events->where('city', 'LIKE', '%' . $request['city'] . '%');
            }
            if($request['description']) {
                $events = $events->where('description', 'LIKE', '%' . $request['description'] . '%');
            }
            if($request['type']) {
                foreach(json_decode($request['type']) as $type) {
                    $allEventsWithType = EventType::where('type_id', '=', $type)->pluck('event_id');
                    $events = $events->whereIn('id', $allEventsWithType);
                }
            }
        }

        if($request->ajax()) {
            return View::make('event-page')->with([
                'events' => $events->paginate(10, ['*'], 'eventPage'),
                'types' => $types,
                'includeform' => $includeform,
            ]);
        }
        return View::make('events')->with([
            'events' => $events->paginate(10, ['*'], 'eventPage'),
            'types' => $types,
            'includeform' => $includeform,
        ]);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        $fields = $request->validated();
        $event_fields['name'] = strip_tags($fields['name']);
        $event_fields['date_start'] = $fields['date_start'];
        if(isset($fields['date_end'])) {
            $event_fields['date_end'] = $fields['date_end'];
        }
        $event_fields['city'] = strip_tags($fields['city']);
        $event_fields['location'] = strip_tags($fields['location']);
        if(isset($fields['description'])) {
            $event_fields['description'] = strip_tags($fields['description']);
        }
        if($request->hasFile('image')) {
            $path = $request->file('image')->store('userImages', 'public');
            $event_fields['image'] = $path;
        }
        $event_fields['is_public'] = $fields['is_public'];
        $event_fields['owner_id'] = Auth::user()->id;
        $event = Event::create($event_fields);

        if(isset($fields['type'])) {
            foreach($fields['type'] as $type) {
                $type_fields['type_id'] = $type;
                $type_fields['event_id'] = $event['id'];
                $event_type = EventType::create($type_fields);
            }
        }

        $events = Event::where('owner_id', '=', Auth::user()->id)->orderBy('date_start', 'asc');

        return View::make('event-page')->with([
            'events' => $events->paginate(10, ['*'], 'eventPage'),
            'types' => Type::all(),
            'includeform' => true,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ShowEventRequest $request, Event $event)
    {
        $fields = $request->validated();
        if(isset($fields['card'])) {
            return View::make('event-card')->with([
                'event' => $event,
                'types' => Type::all(),
                'includeform' => true,
            ]);
        }
        if(Auth::guest()) {
            return View::make('event-details')->with([
                'event' => Event::where('id', '=', $event['id'])->with('allAttendees')->get()[0],
            ]);
        } else {
            return View::make('event-details')->with([
                'event' => Event::where('id', '=', $event['id'])->with(['attendees' => function($q){
                    $q->where('attendees.user_id', '=', Auth::user()->id);
                }])->with('allAttendees')->get()[0],
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return View::make('edit-event-form')->with([
            'event' => $event,
            'types' => Type::all(),
            'includeform' => true,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $fields = $request->validated();
        if(empty($fields)) {
            Storage::disk('public')->delete($event['image']);
            $event->image = null;
            $event->save();
            return;
        }
        $event->name = strip_tags($fields['name']);
        $event->date_start = $fields['date_start'];
        $event->date_end = $fields['date_end'];
        $event->city = strip_tags($fields['city']);
        $event->location = strip_tags($fields['location']);
        $event->description = strip_tags($fields['description']);
        if($request->hasFile('image')) {
            $path = $request->file('image')->store('userImages', 'public');
            $event->image = $path;
        }
        $event->is_public = $fields['is_public'];
        $event->save();

        $previousTypes = EventType::where('event_id', '=', $event['id'])->get();
        foreach ($previousTypes as $previousType) {
            $previousType->delete($previousType);
        }
        if(isset($fields['type'])) {
            foreach($fields['type'] as $type) {
                $type_fields['type_id'] = $type;
                $type_fields['event_id'] = $event['id'];
                $event_type = EventType::create($type_fields);
            }
        }

        return View::make('event-card')->with([
            'event' => $event,
            'types' => Type::all(),
            'includeform' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyEventRequest $request, Event $event)
    {
        if($event['image']) {
            Storage::disk('public')->delete($event['image']);
        }
        $event->delete($event);
    }
}
