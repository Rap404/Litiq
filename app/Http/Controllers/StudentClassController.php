<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use Illuminate\Http\Request;

class StudentClassController extends Controller
{
    public function show(ClassRoom $class){
        return view(
            'siswa.class.show',
            compact('class')
        );
    }
}
