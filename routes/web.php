<?php

use App\Http\Controllers\ClassRoomController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JoinClassController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('classes', ClassRoomController::class);

    Route::get('/join-class', [JoinClassController::class, 'index'])
    ->name('join.class');
    Route::post('/join-class', [JoinClassController::class, 'store'])
    ->name('join.class.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/classes/{class}/materials', [MaterialController::class, 'store'])->name('materials.store');

require __DIR__.'/auth.php';
