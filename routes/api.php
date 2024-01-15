<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\GoogleCalendar\Event;
use App\Http\Controllers\EventController;
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




Route::middleware('auth:api')->get('/gg', function () {
        return view('/api/calendarlogin');
          });

Route::middleware('auth:api')->get('/calendar-home', function () {
  return view('api/calendarpage');
    });

Route::middleware('auth:api')->get('event-view', 'App\Http\Controllers\ViewEventController@index');
Route::middleware('auth:api')->post('event-view', 'App\Http\Controllers\ViewEventController@show');


Route::middleware('auth:api')->post('/create-event', 'App\Http\Controllers\CalendarController@createEvent');
Route::middleware('auth:api')->get('/edit-event', 'App\Http\Controllers\EditCalController@index');
Route::middleware('auth:api')->post('/update-event', 'App\Http\Controllers\EditCalController@editEvent');