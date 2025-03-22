<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use View;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $events = Event::where('owner_id', '=', Auth::user()->id)->paginate(10);

        return View::make('home')->with([
            'events' => $events,
        ]);
    }
}
