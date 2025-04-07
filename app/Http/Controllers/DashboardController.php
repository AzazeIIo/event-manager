<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Event;
use App\Models\Invitation;
use App\Models\Attendee;
use App\Models\EventType;
use View;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        if(!Auth::check()) {
            return redirect('/login');
        }

        date_default_timezone_set('Europe/Budapest');
        $date = new \DateTimeImmutable();

        $activeEvents = Event::where('date_start', '>=', $date->format('Y-m-d'))->orWhere('date_end', '>=', $date->format('Y-m-d'))->pluck('id');

        $yourEvents = Event::where('owner_id', '=', Auth::user()->id)->whereIn('id', $activeEvents)->orderBy('date_start', 'asc')->get();

        $joinedEvents = Event::whereIn('id', (Attendee::where('user_id', '=', Auth::user()->id)->pluck('event_id')))
            ->whereIn('id', $activeEvents)
            ->with(['attendees' => function($q){
                $q->where('attendees.user_id', '=', Auth::user()->id);
            }])->with('allAttendees')->orderBy('date_start', 'asc')->get();


        $yourTypes = EventType::whereIn('event_id', Event::where('owner_id', '=', Auth::user()->id)->whereIn('id', $activeEvents)->pluck('id'))
            ->join('types', 'event_types.type_id', '=', 'types.id')
            ->select(DB::raw('count(*) as count, type_name as name'))
            ->groupBy('type_name')
            ->get();

        $joinedTypes = EventType::whereIn('event_id', Event::whereIn('id', (Attendee::where('user_id', '=', Auth::user()->id)->pluck('event_id')))->whereIn('id', $activeEvents)->pluck('id'))
            ->join('types', 'event_types.type_id', '=', 'types.id')
            ->select(DB::raw('count(*) as count, type_name as name'))
            ->groupBy('type_name')
            ->get();


        $allYourEvents = Event::where('owner_id', '=', Auth::user()->id)
            ->orWhere(function ($q) {
                $q->whereIn('id', (Attendee::where('user_id', '=', Auth::user()->id)->pluck('event_id')));
            })->pluck('id');
        $currentEvents = Event::whereIn('id', $allYourEvents)
            ->where('date_start', '<', $date->format('Y-m-d'))
            ->where('date_end', '>=', $date->format('Y-m-d'))
            ->select(DB::raw('CAST(date_start AS DATE) as start_day, CAST(date_end AS DATE) as end_day'))
            ->get();
        $futureEvents = Event::whereIn('id', $allYourEvents)
            ->where('date_start', '>=', $date->format('Y-m-d'))
            ->where('date_start', '<=', $date->modify('+30 days')->format('Y-m-d'))
            ->select(DB::raw('CAST(date_start AS DATE) as start_day, CAST(date_end AS DATE) as end_day'))
            ->get();        

        $days = [];
        $current = new \DateTime();
        for($i = 0; $i < 30; $i++, $current->modify('+1 day')) {
            array_push($days, $current->format("Y-m-d"));
        }

        $count = array_fill(0, 30, 0);

        foreach ($futureEvents as $event) {
            $indexStart = array_search($event['start_day'], $days);
            if($event['end_day'] == null) {
                $count[$indexStart]++;
            } else {
                $indexEnd = array_search($event['end_day'], $days);
                if($indexEnd == null) {
                    $indexEnd = 29;
                }
                for ($j = $indexStart; $j <= $indexEnd; $j++) { 
                    $count[$j]++;
                }
            }
        }

        foreach ($currentEvents as $event) {
            $indexStart = array_search($event['end_day'], $days);
            for ($j = $indexStart; $j >= 0; $j--) { 
                $count[$j]++;
            }
        }

        return View::make('dashboard')->with([
            'yourEvents' => $yourEvents,
            'joinedEvents' => $joinedEvents,
            'yourTypes' => $yourTypes,
            'joinedTypes' => $joinedTypes,
            'days' => $days,
            'count' => $count
        ]);
    }
}
