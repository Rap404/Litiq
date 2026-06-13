<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\Quiz;
use App\Models\QuizResult;
use Illuminate\Http\Request;

class StudentQuizController extends Controller
{
    public function show(Quiz $quiz){
        return view(
            'siswa.quiz.show',
            compact('quiz')
        );
    }

    public function submit(Request $request, Quiz $quiz){
        $score = 0;

        foreach($quiz->questions as $question){
            $answer =
            $request->answers[$question->id] ?? null;


            if($answer === $question->correct_answer){
                $score++;
            }
            }

        $totalQuestions = $quiz->questions->count();

        $finalScore = ($score / $totalQuestions) * 100;

        $xpEarned = max(
                50,
                round(($finalScore / 100) * 50)
            );

        QuizResult::create([
            'student_id' => auth()->id(),
            'quiz_id' => $quiz->id,
            'score' => $finalScore,
            'xp_earned' => $xpEarned,
        ]);

        $user = auth()->user();

        $user->xp += $xpEarned;

        $user->save();

        $user->level = floor($user->xp / 100) + 1;

        $user->save();

        $firstQuizBadge = Badge::where(
            'name',
            'First Quiz',
        )->first();

        if ($firstQuizBadge &&
            auth()->user()->quizResults()->count() == 1) {
            auth()->user()
            ->badges()
            ->syncWithoutDetaching([$firstQuizBadge->id]);
        }

       if ($finalScore == 100) {
        $badge = Badge::where('name', 'Perfect Score')->first();

        if ($badge) {
         auth()->user()
            ->badges()
            ->syncWithoutDetaching([$badge->id]);
        }
}

        if($user->level >= 5){
            $badge = Badge::where(
                'name',
                'Level 5'
            )->first();

            auth()->user()
    ->badges()
    ->syncWithoutDetaching([$badge->id]);
        }

        return redirect()
        ->route('dashboard')
        ->with('success', 'Nilai kamu ' . $finalScore);

        }
}
