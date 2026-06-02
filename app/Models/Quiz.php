<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'class_id',
        'title',
        'xp_reward'
    ];

    public function classRoom(){
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
