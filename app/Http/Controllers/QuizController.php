<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Level;
use App\Models\Question;
use App\Models\UserProgress;
use App\Models\BlackBook;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function start(Level $level)
    {
        $user = Auth::user();

        // 1. Check Gatekeeper logic (Level 10, 20 etc)
        if ($level->order > 1 && $level->order % 10 == 0) {
            // Check if user has required_streak (defined in levels table)
            if ($user->current_streak < $level->required_streak) {
                return redirect()->route('dashboard')->with('error', "Gatekeeper says: You need a streak of {$level->required_streak} to enter this level!");
            }
        }

        // 2. Fetch Questions based on Mood
        $query = Question::where('level_id', $level->id);

        // Dynamic Difficulty based on Mood
        if (in_array($user->mood, ['sad', 'angry'])) {
            $query->where('difficulty', '<=', 2); // Exclude hard questions
        }

        $questions = $query->inRandomOrder()->take(5)->get();

        if ($questions->isEmpty()) {
            return redirect()->route('dashboard')->with('error', 'Sensei is still preparing questions for this level.');
        }

        // 3. Initialize Quiz Session
        session(['quiz' => [
            'level_id' => $level->id,
            'questions' => $questions->pluck('id')->toArray(),
            'current_index' => 0,
            'score' => 0,
            'correct_count' => 0,
            'paw_used_this_quiz' => false
        ]]);

        return redirect()->route('quiz.show');
    }

    public function show()
    {
        $quiz = session('quiz');
        if (!$quiz) return redirect()->route('dashboard');

        $questionId = $quiz['questions'][$quiz['current_index']];
        $question = Question::find($questionId);
        $level = Level::find($quiz['level_id']);

        return view('quiz.show', compact('question', 'level', 'quiz'));
    }

    public function answer(Request $request)
    {
        $request->validate(['answer' => 'required|string']);
        $user = Auth::user();
        $quiz = session('quiz');
        if (!$quiz) return redirect()->route('dashboard');

        $question = Question::find($quiz['questions'][$quiz['current_index']]);
        $isCorrect = trim(strtolower($request->answer)) === trim(strtolower($question->correct_answer));

        if ($isCorrect) {
            $quiz['score'] += ($question->difficulty * 10);
            $quiz['correct_count']++;

            // Streak Logic
            $user->current_streak++;
            if ($user->current_streak > $user->highest_streak) {
                $user->highest_streak = $user->current_streak;
            }

            // Award Koban
            $user->koban += ($question->difficulty * 2);

            // Neko-Punch Reward: 1 Paw every 5 streak
            if ($user->current_streak > 0 && $user->current_streak % 5 == 0) {
                $user->paw_points++;
            }
        } else {
            // Reset streak on wrong answer
            $user->current_streak = 0;

            // Save to Black Book
            $blackBook = BlackBook::firstOrNew([
                'user_id' => $user->id,
                'question_id' => $question->id
            ]);
            $blackBook->wrong_count += 1;
            $blackBook->correct_streak = 0; // Reset mastery streak
            $blackBook->is_mastered = false;
            $blackBook->save();
        }

        $user->save();

        // Advance to next question
        $quiz['current_index']++;
        session(['quiz' => $quiz]);

        if ($quiz['current_index'] >= count($quiz['questions'])) {
            return redirect()->route('quiz.results');
        }

        return redirect()->route('quiz.show')->with($isCorrect ? 'success' : 'error', $isCorrect ? 'Sugoi!' : 'Chigau! Correct answer: ' . $question->correct_answer);
    }

    public function usePaw()
    {
        $user = Auth::user();
        $quiz = session('quiz');

        if ($user->paw_points > 0) {
            $user->paw_points--;
            $user->save();

            // Trigger lifeline in view (handled by session/flash)
            return back()->with('neko_punch', true);
        }

        return back()->with('error', 'No Paw Points left!');
    }

    public function results()
    {
        $quiz = session('quiz');
        if (!$quiz) return redirect()->route('dashboard');

        $level = Level::find($quiz['level_id']);
        $score = $quiz['score'];
        $correct = $quiz['correct_count'];
        $total = count($quiz['questions']);

        // Update progress if at least 60% correct
        if (($correct / $total) >= 0.6) {
            // Award Level Completion Bonus
            $bonus = 100;
            $user = Auth::user();
            $user->koban += $bonus;
            $user->save();

            Transaction::create([
                'user_id' => $user->id,
                'amount' => $bonus,
                'type' => 'reward',
                'description' => "Level completion bonus: {$level->name}"
            ]);

            UserProgress::updateOrCreate(
                ['user_id' => Auth::id(), 'level_id' => $level->id],
                ['status' => 'passed', 'high_score' => max($quiz['score'], 0)]
            );

            // Unlock next level if exists
            $nextLevel = Level::where('region_id', $level->region_id)
                ->where('order', '>', $level->order)
                ->orderBy('order')
                ->first();

            if ($nextLevel) {
                UserProgress::firstOrCreate(
                    ['user_id' => Auth::id(), 'level_id' => $nextLevel->id],
                    ['status' => 'unlocked']
                );
            }
        }

        // Clear session
        session()->forget('quiz');

        return view('quiz.results', compact('level', 'score', 'correct', 'total'));
    }
}
