<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function store(Request $request, ClassRoom $class){
        $request->validate([
            'title' => 'required'
        ]);

        Quiz::create([
            'class_id' => $class->id,
            'title' => $request->title,
            'xp_award' => 50
        ]);

        return back();
    }

    public function show(Quiz $quiz){
        $questions = $quiz->questions->map(function ($q) {
    return [
        'id'       => $q->id,
        'question' => $q->question,
        'opts'     => [
            $q->option_a,
            $q->option_b,
            $q->option_c,
            $q->option_d
        ]
    ];
});

        return view('siswa.quiz.show', compact('quiz', 'questions'));
    }

    public function storeQuestion(Request $request, Quiz $quiz){
        $request->validate([
            'question' => 'required',
            'option_a' => 'required',
            'option_b' => 'required',
            'option_c' => 'required',
            'option_d' => 'required',
            'correct_answer' => 'required',
        ]);

        Question::create([
            'quiz_id' => $quiz->id,
            'question' => $request->question,

            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,

            'correct_answer' => $request->correct_answer
        ]);

        return back();
    }
}
