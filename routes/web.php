<?php

use App\Http\Controllers\ClubController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'president'])->group(function () {
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('event.edit');
    Route::put('/events/{event}/update', [EventController::class, 'update'])->name('event.update');

    });

Route::middleware(['auth', 'admin'])->group(function () {
// Route::get('/adminhomepage', [HomeController::class, 'index'])->name('adminhomepage');
Route::get('/userhomepage', [HomeController::class, 'userhomepage'])->name('dashboard');

Route::get('/useradmin', [UserController::class, 'index'])->name('useradmin.index');
Route::get('/useradmin/create', [UserController::class, 'create'])->name('useradmin.create');
Route::post('/useradmin', [UserController::class, 'store'])->name('useradmin.store');
Route::get('/useradmin/{user}/edit', [UserController::class, 'edit'])->name('useradmin.edit');
Route::put('/useradmin/{user}/update', [UserController::class, 'update'])->name('useradmin.update');
Route::delete('/useradmin/{user}/destroy', [UserController::class, 'destroy'])->name('useradmin.destroy');


Route::get('/clubadmin', [ClubController::class, 'index'])->name('clubs.index');
Route::get('/clubadmin/create', [ClubController::class, 'create'])->name('clubs.create');
Route::post('/clubadmin', [ClubController::class, 'store'])->name('clubs.store');
Route::get('/clubadmin/{club}/edit', [ClubController::class, 'edit'])->name('clubs.edit');
Route::put('/clubadmin/{club}/update', [ClubController::class, 'update'])->name('clubs.update');
Route::delete('/clubadmin/{club}/destroy', [ClubController::class, 'destroy'])->name('clubs.destroy');
});






Route::middleware('auth')->group(function () {

    Route::get('/home', [HomeController::class,'index'])->middleware(['auth', 'verified'])->name('home');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/clubuser', [ClubController::class, 'homepage'])->name('clubuser_hariz.homepage');
    // web.php
    Route::get('/clubs/{club}', [ClubController::class, 'detail'])->name('clubuser_hariz.clubdetail');

    Route::get('/eventhomepage', [EventController::class, 'homepage'])->name('eventuser.homepage');
    Route::get('/events/{event}', [EventController::class, 'detail'])->name('event.index');
});

require __DIR__.'/auth.php';
