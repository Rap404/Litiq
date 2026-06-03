<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if(auth()->user()?->role === 'guru'){
            return view('guru.dashboard');
        }

        return view('siswa.dashboard');
    }
}
