<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

Auth::routes();

Route::redirect('/', 'events');
Route::resource('events', EventController::class);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
