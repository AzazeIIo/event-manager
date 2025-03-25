<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Type;
use App\Models\EventType;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEventRequest;
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
        $events = Event::where('is_public', '=', true)->orderBy('date_start', 'asc')->paginate(10);
        $types = Type::all();

        if($request->ajax()) {
            return View::make('event_page')->with([
                'events' => $events,
                'types' => $types,
                'includeform' => false
            ]);
        }

        return View::make('events')->with([
            'events' => $events,
            'types' => $types,
            'includeform' => false
        ]);
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
    public function store(StoreEventRequest $request)
    {
        $fields = $request->validated();
        $event_fields = [];
        $event_fields['name'] = strip_tags($fields['name']);
        $event_fields['date_start'] = strip_tags($fields['date_start']);
        $event_fields['date_end'] = strip_tags($fields['date_end']);
        $event_fields['city'] = strip_tags($fields['city']);
        $event_fields['location'] = strip_tags($fields['location']);
        $event_fields['description'] = strip_tags($fields['description']);
        if($request->hasFile('image')) {
            $path = $request->file('image')->store('userImages', 'public');
            $event_fields['image'] = $path;
        }
        $event_fields['is_public'] = strip_tags($fields['is_public']);
        $event_fields['owner_id'] = strip_tags($fields['owner_id']);
        $event = Event::create($event_fields);

        if(isset($fields['type'])) {
            $types = [];
            foreach($fields['type'] as $type) {
                $type_fields['type_id'] = strip_tags($type);
                $type_fields['event_id'] = $event['id'];
                $event_type = EventType::create($type_fields);
                array_push($types, $event_type);
            }
            return response()->json([$event, $types]);
            //$types = json_encode($stripped);
        }

        return response()->json([$event]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return View::make('event_details')->with([
            'event' => $event
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyEventRequest $request)
    {
        $request->validated();
        $event = Event::find($request['event_id']);
        if($event['image']) {
            Storage::disk('public')->delete($event['image']);
        }
        $event->delete($event);
    }
}
