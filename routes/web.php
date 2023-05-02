<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::group(['prefix'=>'admin', 'middleware' => 'auth'], function() {
    Route::get('/', [App\Http\Controllers\RoomController::class, 'index'])->name('home');
    Route::get('/add', [App\Http\Controllers\RoomController::class, 'create'])->name('add');
    Route::post('/add', [App\Http\Controllers\RoomController::class, 'store'])->name('store');
    Route::get('/edit/{roomId}', [App\Http\Controllers\RoomController::class, 'edit'])->name('edit');
    Route::post('/edit/{roomId}', [App\Http\Controllers\RoomController::class, 'update'])->name('update');
});
Route::group(['middleware' => 'auth'], function() {
    Route::get('/', [App\Http\Controllers\RoomController::class, 'index'])->name('home');
    Route::get('/reserve/{roomId}', [App\Http\Controllers\RoomController::class, 'reservePage'])->middleware('reserved')->name('reservePage');
    Route::post('/reserve/{roomId}', [App\Http\Controllers\RoomController::class, 'reserve'])->name('reserve');
    Route::post('/reserve/unset/{roomId}', [App\Http\Controllers\RoomController::class, 'unset'])->name('unset');
});