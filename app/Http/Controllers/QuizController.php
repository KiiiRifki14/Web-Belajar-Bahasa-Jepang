<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Level;
use App\Models\User;
use App\Models\UserProgress;
use App\Models\BlackBook;
use App\Models\Transaction;
use App\Models\MemoryAlbum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class QuizController extends Controller
{
    /**
     * Memulai sesi kuis untuk level tertentu.
     * Mengatur status level menjadi 'unlocked' jika sebelumnya 'locked'.
     */
    public function start(Level $level)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Pastikan level terdaftar di progress user - default ke 'locked' untuk mencegah cheat bypass
        $progress = UserProgress::firstOrCreate(
            ['user_id' => $user->id, 'level_id' => $level->id],
            ['status' => 'locked']
        );

        // Jika level masih terkunci, jangan izinkan akses
        if ($progress->status === 'locked') {
            return back()->with('error', 'Level ini masih terkunci! Selesaikan level sebelumnya.');
        }

        // Ambil soal berdasarkan mood user (Dynamic Difficulty)
        $query = Question::where('level_id', $level->id);

        // Logika Mood Tracker: Jika mood buruk, ambil soal yang lebih mudah (Multiple Choice)
        if (in_array($user->mood, ['sad', 'angry'])) {
            $query->where('type', 'multiple_choice');
        }

        $questions = $query->inRandomOrder()->get();

        if ($questions->isEmpty()) {
            return back()->with('error', 'Belum ada soal untuk level ini.');
        }

        // Simpan sesi kuis (Quiz Engine state)
        session(['quiz' => [
            'level_id' => $level->id,
            'questions' => $questions->pluck('id')->toArray(),
            'current_index' => 0,
            'correct_answers' => 0
        ]]);

        return redirect()->route('quiz.show');
    }

    /**
     * Menampilkan soal kuis saat ini.
     * Mengirimkan data ke Blade split-screen (Visual vs Kuis).
     */
    public function show()
    {
        $quiz = session('quiz');
        if (!$quiz) return redirect()->route('dashboard');

        $currentIndex = $quiz['current_index'];
        $questionId = $quiz['questions'][$currentIndex];
        $question = Question::find($questionId);
        $level = Level::with('region')->find($quiz['level_id']);
        /** @var \App\Models\User $user */
        $user = Auth::user();

        return view('quiz.show', compact('question', 'level', 'currentIndex', 'quiz', 'user'));
    }

    /**
     * Mengaktifkan Neko-Punch (Lifeline).
     * Mengurangi paw_points dan memberikan sinyal ke view untuk menyembunyikan opsi salah via session.
     */
    public function usePaw()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user->paw_points > 0) {
            $user->decrement('paw_points');
            session(['neko_punch' => true]);
            return back()->with('success', 'Neko-Punch diaktifkan! 🐾');
        }
        return back()->with('error', 'Paw Points tidak cukup!');
    }

    /**
     * Memproses jawaban kuis.
     * Mengatur skor, streak, dan mencatat kesalahan ke Buku Hitam (Automated Tracker).
     */
    public function answer(Request $request)
    {
        $request->validate(['answer' => 'required', 'question_id' => 'required']);

        $quiz = session('quiz');
        if (!$quiz) return redirect()->route('dashboard');

        $question = Question::find($request->question_id);
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Hapus session Neko-Punch setelah digunakan/dijawab agar tidak terbawa ke soal selanjutnya
        session()->forget('neko_punch');

        $isCorrect = (trim(strtolower($request->answer)) === trim(strtolower($question->correct_answer)));

        if ($isCorrect) {
            $quiz['correct_answers']++;
            $user->increment('current_streak');

            // Update highest_streak jika current_streak memecahkan rekor pribadi
            if ($user->current_streak > $user->highest_streak) {
                $user->update(['highest_streak' => $user->current_streak]);
            }

            // Hadiah Paw Points setiap kelipatan 5 streak (Incentive)
            if ($user->current_streak % 5 === 0) {
                $user->increment('paw_points');
            }
        } else {
            // Reset streak jika salah (The streak legend)
            $user->update(['current_streak' => 0]);

            // Catat ke Buku Hitam (The Tracker) untuk dipelajari nanti di mode Rematch
            $blackBook = BlackBook::firstOrNew([
                'user_id' => $user->id,
                'question_id' => $question->id
            ]);
            $blackBook->wrong_count++;
            $blackBook->correct_streak = 0; // Reset mastery progress
            $blackBook->is_mastered = false;
            $blackBook->save();
        }

        $quiz['current_index']++;
        session(['quiz' => $quiz]);

        // Cek apakah kuis sudah mencapai soal terakhir
        if ($quiz['current_index'] >= count($quiz['questions'])) {
            return $this->finishQuiz($quiz);
        }

        return redirect()->route('quiz.show');
    }

    /**
     * Menyelesaikan sesi kuis, memberikan reward Koban, dan membuka level baru.
     */
    private function finishQuiz($quiz)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $level = Level::find($quiz['level_id']);
        $totalQuestions = count($quiz['questions']);
        $score = ($quiz['correct_answers'] / $totalQuestions) * 100;

        // Tandai level saat ini sebagai 'passed'
        UserProgress::where('user_id', $user->id)
            ->where('level_id', $level->id)
            ->update(['status' => 'passed']);

        // Logika Buka Level Berikutnya (Progressive Unlock)
        $nextLevel = Level::where('region_id', $level->region_id)
            ->where('order', $level->order + 1)
            ->first();

        // Jika tidak ada level selanjutnya di region ini, melompat ke Level 1 di Region berikutnya
        if (!$nextLevel) {
            $nextRegion = \App\Models\Region::where('order', $level->region->order + 1)->first();
            if ($nextRegion) {
                $nextLevel = Level::where('region_id', $nextRegion->id)
                    ->where('order', 1)
                    ->first();
            }
        }

        if ($nextLevel) {
            UserProgress::firstOrCreate(
                ['user_id' => $user->id, 'level_id' => $nextLevel->id],
                ['status' => 'unlocked']
            );
        }

        // Reward Koban (Koin Emas) berdasarkan jumlah jawaban benar
        $reward = $quiz['correct_answers'] * 10;
        $user->increment('koban', $reward);

        // Catat riwayat transaksi reward
        Transaction::create([
            'user_id' => $user->id,
            'amount' => $reward,
            'type' => 'reward',
            'description' => 'Reward penyelesaian Level ' . $level->name
        ]);

        // Jika Boss Level dan skor mencukupi, simpan ke Buku Kenangan (Memory Album)
        if ($level->is_boss_level && $score >= 80) {
            MemoryAlbum::firstOrCreate([
                'user_id' => $user->id,
                'level_id' => $level->id,
                'image_path' => $level->questions()->first()?->visual_hint_path ?? 'default_boss.png',
                'earned_at' => now()
            ]);
        }

        // Hapus session kuis agar bersih
        session()->forget('quiz');
        return redirect()->route('dashboard')->with('success', "Level Selesai! Skor: $score%. Anda mendapat $reward Koban!");
    }
}
