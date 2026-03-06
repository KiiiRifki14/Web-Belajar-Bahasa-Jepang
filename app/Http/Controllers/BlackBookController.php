<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlackBook;
use App\Models\Question;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BlackBookController extends Controller
{
    /**
     * Menampilkan daftar soal yang salah dan belum dikuasai.
     * Estetika: Perpustakaan Tua.
     */
    public function index()
    {
        $user = Auth::user();
        $mistakes = BlackBook::where('user_id', $user->id)
            ->where('is_mastered', false)
            ->with('question.level.region')
            ->get();

        return view('black_book.index', compact('mistakes'));
    }

    /**
     * Memulai sesi "Rematch" (Balas Dendam) untuk soal-soal di Buku Hitam.
     */
    public function startRematch()
    {
        $user = Auth::user();
        $mistakes = BlackBook::where('user_id', $user->id)
            ->where('is_mastered', false)
            ->pluck('question_id')
            ->toArray();

        if (empty($mistakes)) {
            return back()->with('error', 'Buku Hitam Anda kosong! Belajarlah lebih giat.');
        }

        session(['black_book_session' => [
            'questions' => $mistakes,
            'current_index' => 0,
            'correct_count' => 0
        ]]);

        return redirect()->route('black_book.show');
    }

    /**
     * Menampilkan soal dalam sesi Rematch.
     */
    public function show()
    {
        $session = session('black_book_session');
        if (!$session) return redirect()->route('black_book.index');

        $questionId = $session['questions'][$session['current_index']];
        $question = Question::find($questionId);
        $mistake = BlackBook::where('user_id', Auth::id())
            ->where('question_id', $questionId)
            ->first();

        return view('black_book.show', compact('question', 'mistake', 'session'));
    }

    /**
     * Memproses jawaban di mode Rematch.
     * Logika Mastery: Harus benar 3 kali berturut-turut untuk dianggap "Lulus" (Mastered).
     */
    public function answer(Request $request)
    {
        $request->validate(['answer' => 'required', 'question_id' => 'required']);
        $session = session('black_book_session');
        $question = Question::find($request->question_id);
        $user = Auth::user();

        $mistake = BlackBook::where('user_id', $user->id)
            ->where('question_id', $question->id)
            ->first();

        $isCorrect = (trim(strtolower($request->answer)) === trim(strtolower($question->correct_answer)));

        if ($isCorrect) {
            $session['correct_count']++;
            $mistake->increment('correct_streak');

            // Logika Mastery: 3 kali benar berturut-turut
            if ($mistake->correct_streak >= 3) {
                $mistake->update(['is_mastered' => true]);
            }
        } else {
            // Reset Mastery streak jika salah lagi
            $mistake->update(['correct_streak' => 0]);
        }

        $mistake->save();

        $session['current_index']++;
        session(['black_book_session' => $session]);

        if ($session['current_index'] >= count($session['questions'])) {
            return redirect()->route('black_book.results');
        }

        // Jika belum selesai, arahkan kembali ke soal berikutnya
        return redirect()->route('black_book.show');
    }

    public function results()
    {
        // Gunakan nama session yang benar: 'black_book_session'
        $session = session('black_book_session');
        if (!$session) return redirect()->route('black_book.index');

        $correct = $session['correct_count'];
        $total = count($session['questions']);

        session()->forget('black_book_session');

        return view('black_book.results', compact('correct', 'total'));
    }
}
