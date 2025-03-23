<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\DestroyEventRequest;
use View;
use Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::where('is_public', '=', true)->orderBy('date_start', 'asc')->paginate(10);
        
        return View::make('events')->with([
            'events' => $events,
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
        $fields['name'] = strip_tags($fields['name']);
        $fields['date_start'] = strip_tags($fields['date_start']);
        $fields['date_end'] = strip_tags($fields['date_end']);
        $fields['city'] = strip_tags($fields['city']);
        $fields['location'] = strip_tags($fields['location']);
        if(isset($fields['type'])) {
            $stripped = [];
            foreach($fields['type'] as $type) {
                $type = strip_tags($type);
                array_push($stripped, $type);
            }
            $fields['type'] = json_encode($stripped);
        } else {
            $fields['type'] = '[]';
        }
        $fields['description'] = strip_tags($fields['description']);
        if($request->hasFile('image')) {
            $path = $request->file('image')->store('userImages', 'public');
            $fields['image'] = $path;
        }
        $fields['is_public'] = strip_tags($fields['is_public']);
        $fields['owner_id'] = strip_tags($fields['owner_id']);
        $event = Event::create($fields);
        return response()->json([$event]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {        
        return View::make('event')->with([
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
        $event->delete($event);
    }
}
