<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AttendeeController;
//use App\Http\Controllers\HomeController;
use App\Models\Event;

Auth::routes();

Route::resource('events', EventController::class);
Route::resource('events.attendees', AttendeeController::class);

Route::redirect('/', 'events');
Route::redirect('/joinedevents', 'myevents')->name('joinedevents');
Route::get('/myevents', function () {
    if(Auth::check()){
        return View::make('events')->with([
            'events' => Event::where('owner_id', '=', Auth::user()->id)->paginate(10),
            'includeform' => true
        ]);
    } else {
        return redirect('/login');
    }
})->name('myevents');
//Route::get('/home', [EventController::class, 'index'])->name('home');
