<?php

use App\Http\Controllers\ClassRoomController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JoinClassController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\StudentClassController;
use App\Http\Controllers\StudentQuizController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::resource('classes', ClassRoomController::class);
    Route::post('/classes/{class}/materials', [MaterialController::class, 'store'])->name('materials.store');
    Route::post('/classes/{class}/quizzes', [QuizController::class, 'store'])->name('quizzes.store');
    Route::get('/quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');
    Route::post('/quizzes/{quiz}/questions', [QuizController::class, 'storeQuestion'])->name('questions.store');

});

Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/join-class', [JoinClassController::class, 'index'])
    ->name('join.class');

    Route::post('/join-class', [JoinClassController::class, 'store'])
    ->name('join.class.store');

    Route::get('/student/classes/{class}', [StudentClassController::class, 'show'])->name('student.classes.show');

    Route::get('/student/quizzes/{quiz}',[StudentQuizController::class, 'show'])->name('student.quiz.show');

Route::post('/student/quizzes/{quiz}', [StudentQuizController::class, 'submit'])->name('student.quiz.submit');
});


require __DIR__.'/auth.php';
