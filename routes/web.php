<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AttendeeController;
//use App\Http\Controllers\HomeController;
use App\Models\Event;
use App\Models\Type;
use App\Models\Invitation;

Auth::routes();

Route::resource('events', EventController::class);
Route::resource('events.attendees', AttendeeController::class);

Route::redirect('/', 'events');
Route::redirect('/joinedevents', 'myevents')->name('joinedevents');
Route::get('/privateevents', function () {
    if(Auth::check()) {
        return View::make(request()->ajax() ? 'event-page' : 'events')->with([
            'events' => Event::whereIn('id', Invitation::where('user_id', '=', Auth::user()->id)->select('event_id')->get())->paginate(10),
            'types' => Type::all(),
            'includeform' => false
        ]);
    } else {
        return redirect('/login');
    }
})->name('privateevents');
Route::get('/myevents', function () {
    if(Auth::check()) {
        return View::make(request()->ajax() ? 'event-page' : 'events')->with([
            'events' => Event::where('owner_id', '=', Auth::user()->id)->paginate(10),
            'types' => Type::all(),
            'includeform' => true
        ]);
    } else {
        return redirect('/login');
    }
})->name('myevents');
//Route::get('/home', [EventController::class, 'index'])->name('home');
