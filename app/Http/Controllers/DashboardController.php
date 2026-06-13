<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
    if(auth()->user()->role === 'guru')
    {
        $totalClasses = ClassRoom::count();

        $totalStudents = User::where('role', 'murid')->count();

        $totalQuizzes = Quiz::count();

        $leaderboard = User::where('role', 'siswa')
        ->orderByDesc('xp')
        ->take(5)
        ->get();

        $classes = ClassRoom::latest()->get();

        return view('guru.dashboard', compact('totalClasses','totalStudents', 'totalQuizzes','leaderboard', 'classes'));
    }

    $classes = auth()->user()
        ->enrolledClasses()
        ->get();

    $leaderboard = User::where('role', 'siswa')
    ->orderByDesc('xp')
    ->take(10)
    ->get();

    $user = auth()->user();

    $currentLevelXP = ($user->level - 1) * 100;

    $nextLevelXP = $user->level * 100;

    $progressXP = $user->xp - $currentLevelXP;

    $progressPercent =
    min(
        100,
        ($progressXP / 100) * 100
    );

    return view(
    'siswa.dashboard',
    compact(
        'classes',
        'leaderboard',
        'user',
        'progressXP',
        'progressPercent',
        'nextLevelXP'
    )
);
}
}
