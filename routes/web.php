<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\DashboardController;
//use App\Http\Controllers\HomeController;
use App\Models\Event;
use App\Models\Type;
use App\Models\Invitation;
use App\Models\Attendee;

Auth::routes();

Route::resource('events', EventController::class)->except([
    'create'
]);
Route::resource('events.attendees', AttendeeController::class)->only([
    'store', 'destroy'
]);
Route::resource('events.invitations', InvitationController::class)->except([
    'show', 'edit', 'update'
]);

Route::redirect('/', 'events');

Route::get('/privateevents', [EventController::class, 'index'])->name('privateevents');
Route::get('/myevents', [EventController::class, 'index'])->name('myevents');
Route::get('/joinedevents', [EventController::class, 'index'])->name('joinedevents');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
