<?php

namespace App\Http\Controllers;

use App\Models\ClassMember;
use App\Models\ClassRoom;
use Illuminate\Http\Request;

class JoinClassController extends Controller
{
    public function index(){
        return view('siswa.join-class');
    }

    public function store(Request $request){
        $request->validate([
            'class_code' => 'required'
        ]);

        $class = ClassRoom::where('class_code')->first();

        if(!$class){
            return back()
            ->withErrors([
                'class_code' => 'Kode kelas tidak ditemukan'
            ]);
        }

        ClassMember::firstOrCreate([
            'class_id' => $class->id,
            'student_id' => auth()->id(),
        ]);

        return back()
            ->with('success', 'Berhasil bergabung');
    }
}
