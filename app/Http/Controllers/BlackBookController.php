<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlackBook;
use App\Models\Question;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BlackBookController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $items = BlackBook::where('user_id', $user->id)
            ->where('is_mastered', false)
            ->with('question')
            ->orderBy('wrong_count', 'desc')
            ->get();

        $masteredCount = BlackBook::where('user_id', $user->id)
            ->where('is_mastered', true)
            ->count();

        return view('black_book.index', compact('items', 'masteredCount'));
    }

    public function startRematch()
    {
        $user = Auth::user();
        $blackBookItems = BlackBook::where('user_id', $user->id)
            ->where('is_mastered', false)
            ->inRandomOrder()
            ->take(5)
            ->get();

        if ($blackBookItems->isEmpty()) {
            return back()->with('success', 'Your Black Book is empty! You have mastered all your past mistakes.');
        }

        session(['rematch' => [
            'items' => $blackBookItems->pluck('id')->toArray(),
            'current_index' => 0,
            'correct_count' => 0,
        ]]);

        return redirect()->route('black_book.show');
    }

    public function show()
    {
        $rematch = session('rematch');
        if (!$rematch) return redirect()->route('black_book.index');

        $blackBookItem = BlackBook::with('question')->find($rematch['items'][$rematch['current_index']]);

        return view('black_book.show', compact('blackBookItem', 'rematch'));
    }

    public function answer(Request $request)
    {
        $request->validate(['answer' => 'required|string']);
        $user = Auth::user();
        $rematch = session('rematch');
        if (!$rematch) return redirect()->route('black_book.index');

        $blackBookItem = BlackBook::find($rematch['items'][$rematch['current_index']]);
        $question = $blackBookItem->question;

        $isCorrect = trim(strtolower($request->answer)) === trim(strtolower($question->correct_answer));

        if ($isCorrect) {
            $rematch['correct_count']++;

            // Mastery Logic: Correct streak +1
            $blackBookItem->correct_streak += 1;

            // Reward: Half Koban (Difficulty * 1)
            $reward = $question->difficulty * 1;
            $user->koban += $reward;
            $user->save();

            Transaction::create([
                'user_id' => $user->id,
                'amount' => $reward,
                'type' => 'reward',
                'description' => "Rematch reward for mastering: {$question->question_text}"
            ]);

            if ($blackBookItem->correct_streak >= 3) {
                $blackBookItem->is_mastered = true;
            }
        } else {
            // Reset Mastery streak on wrong answer even in Rematch
            $blackBookItem->correct_streak = 0;
            $blackBookItem->wrong_count += 1;
        }

        $blackBookItem->save();

        // Advance
        $rematch['current_index']++;
        session(['rematch' => $rematch]);

        if ($rematch['current_index'] >= count($rematch['items'])) {
            return redirect()->route('black_book.results');
        }

        return redirect()->route('black_book.show')->with($isCorrect ? 'success' : 'error', $isCorrect ? 'Well done! Progressing towards mastery.' : 'Not quite. The streak resets.');
    }

    public function results()
    {
        $rematch = session('rematch');
        if (!$rematch) return redirect()->route('black_book.index');

        $correct = $rematch['correct_count'];
        $total = count($rematch['items']);

        session()->forget('rematch');

        return view('black_book.results', compact('correct', 'total'));
    }
}
