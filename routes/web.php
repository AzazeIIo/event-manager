<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AttendeeController;
//use App\Http\Controllers\HomeController;
use App\Models\Event;
use App\Models\Type;

Auth::routes();

Route::resource('events', EventController::class);
Route::resource('events.attendees', AttendeeController::class);

Route::redirect('/', 'events');
Route::redirect('/joinedevents', 'myevents')->name('joinedevents');
Route::get('/myevents', function () {
    if(Auth::check()) {
        return View::make(request()->ajax() ? 'event_page' : 'events')->with([
            'events' => Event::where('owner_id', '=', Auth::user()->id)->paginate(10),
            'types' => Type::all(),
            'includeform' => true
        ]);
    } else {
        return redirect('/login');
    }
})->name('myevents');
//Route::get('/home', [EventController::class, 'index'])->name('home');
