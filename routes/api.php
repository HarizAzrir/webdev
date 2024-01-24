<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\GoogleCalendar\Event;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GoogleCalendarController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/google-calendar', 'App\Http\Controllers\GoogleCalendarController@index');

Route::get('/calendar-home', function () {
    return view('api/calendarpage');
});
// Example in api.php
Route::get('/index', 'App\Http\Controllers\GoogleCalendarController@index')->name('api.index');

