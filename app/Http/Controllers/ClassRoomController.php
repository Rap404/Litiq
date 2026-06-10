<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Str;

class ClassRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = auth()->user()
            ->classes()
            ->latest()
            ->get();

        return view('guru.classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('guru.classes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'class_name' => 'required|max:255'
        ]);

        ClassRoom::create([
            'teacher_id' => auth()->id(),
            'class_name' => $request->class_name,
            'class_code' => strtoupper(
                Str::random(6)
            ),
        ]);

        return redirect()
            ->route('classes.index')->with('success', 'Kelas berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(ClassRoom $class)
    {
        return view(
            'guru.classes.show',
            compact('class')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
