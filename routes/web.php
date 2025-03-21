<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;

Auth::routes();

Route::redirect('/', 'events');
Route::resource('events', EventController::class);
Route::get('/home', [HomeController::class, 'index'])->name('home');
