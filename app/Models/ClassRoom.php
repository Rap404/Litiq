<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    protected $table = 'classes';

    protected $fillable = [
        'teacher_id',
        'class_name',
        'class_code'
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }


    public function students()
    {
        return $this->belongsToMany(
            User::class,
            'class_members',
            'class_id',
            'student_id'
        );
    }

    public function materials()
    {
        return $this->hasMany(Material::class, 'class_id');
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'class_id');
    }
}
