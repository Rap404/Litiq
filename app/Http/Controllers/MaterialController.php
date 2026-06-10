<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function store(Request $request, ClassRoom $class){
        $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);

        Material::create([
            'class_id' => $class->id,
            'title' => $request->title,
            'content' => $request->content
        ]);

        return back();
    }
}
