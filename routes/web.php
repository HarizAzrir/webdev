<?php

use App\Http\Controllers\ClubController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;

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




Route::middleware(['auth', 'admin'])->group(function () {
Route::get('/adminhomepage', [HomeController::class, 'index'])->name('adminhomepage');
Route::get('/userhomepage', [HomeController::class, 'userhomepage'])->name('dashboard');

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

});

require __DIR__.'/auth.php';
