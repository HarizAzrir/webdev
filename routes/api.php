<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\GoogleCalendar\Event;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GoogleCalendarController;
use App\Http\Controllers\BookmarkController;
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

Route::get('/index/{email?}', 'App\Http\Controllers\GoogleCalendarController@index')->name('api.index');

Route::get('/show-bookmarks', 'App\Http\Controllers\BookmarkController@getBookmarks');
Route::get('/users/{userId}', 'App\Http\Controllers\UserController@show');
Route::get('/events/{eventId}', 'App\Http\Controllers\EventController@show');

// routes/api.php

Route::delete('/bookmarks/{eventId}', 'App\Http\Controllers\BookmarkController@destroy');
