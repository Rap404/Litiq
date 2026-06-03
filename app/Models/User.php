<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email','role', 'xp', 'level', 'password'])]
#[Hidden(['password', 'remember_token'])]

/**
 * @property string $role
 */
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function classes(){
        return $this->hasMany(ClassRoom::class, 'teacher_id');
    }

    public function enrolledClasses(){
        return $this->belongsToMany(
            ClassRoom::class,
            'class_members',
            'student_id',
            'class_id'
        );
    }

    public function quizResults()
    {
        return $this->hasMany(QuizResult::class, 'student_id');
    }

    public function badges()
    {
        return $this->belongsToMany(
            Badge::class,
            'user_badges'
        );
    }
}
